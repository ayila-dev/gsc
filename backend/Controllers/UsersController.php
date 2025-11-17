<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class UsersController
{
    private $host = "localhost";
    private $dbname = "db_gsc";
    private $username = "gsc";
    private $password = "gsc";

    public function Database(): PDO
    {
        try {
            $connect = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->dbname,
                $this->username,
                $this->password
            );
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connect;
        } catch (PDOException $e) {
            die("Connexion échouée : " . $e->getMessage());
        }
    }

    public function generateUserPassword(): string
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789?!_-.,@/\)(#[]|&%$";
        $user_password = "";
        for ($j = 0; $j < 12; $j++) {
            $i = rand(0, strlen($chars) - 1);
            $user_password .= $chars[$i];
        }
        return $user_password;
    }

    public function getLastUserId()
    {
        $db = $this->Database();
        $sql2 = "SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1";
        $query2 = $db->query($sql2);
        $result = $query2->fetch(PDO::FETCH_ASSOC);
        return $result['user_id'] ?? null;
    }

    public function getUserRoleIdByName()
    {
        require_once __DIR__ . "/SettingsController.php";
        $settingsController = new SettingsController();

        if ($_SESSION['page'] === "add-teacher") {
            $getTeacherRoleId = $settingsController->selectRoleByName("Enseignant");
            return $getTeacherRoleId['role_id'] ?? null;
        } elseif ($_SESSION['page'] === "add-student") {
            $getStudentRoleId = $settingsController->selectRoleByName("Apprenant");
            return $getStudentRoleId['role_id'] ?? null;
        } elseif ($_SESSION['page'] === "add-parent") {
            $getParentRoleId = $settingsController->selectRoleByName("Parent");
            return $getParentRoleId['role_id'] ?? null;
        }
        return null;
    }

    public function addUser($data)
    {
        try {
            $db = $this->Database();
            $plain_password = $this->generateUserPassword();

            // Déterminer le role_id en fonction de la page
            if ($_SESSION['page'] === "add-personal") {
                $roleId = $data['role_id'] ?? null;
                if ($roleId === null) {
                    return ["success" => false, "message" => "role_id manquant pour un utilisateur personnel"];
                }
            } else {
                $roleId = $this->getUserRoleIdByName();
                if ($roleId === null) {
                    return ["success" => false, "message" => "Impossible de déterminer le role_id pour l'utilisateur"];
                }
            }

            // Insérer l'utilisateur
            $sql1 = "INSERT INTO users (
                role_id, 
                user_adder_id, 
                user_firstname, 
                user_lastname, 
                user_birth_date, 
                user_sex, 
                user_phone, 
                user_email, 
                user_password
            ) VALUES (
                :role_id, 
                :user_adder_id, 
                :user_firstname, 
                :user_lastname, 
                :user_birth_date, 
                :user_sex, 
                :user_phone, 
                :user_email, 
                :user_password
            )";
            $query1 = $db->prepare($sql1);
            $query1->execute([
                'role_id' => $roleId,
                'user_adder_id' => $_SESSION['user_id'] ?? '',
                'user_firstname' => $data['user_firstname'] ?? '',
                'user_lastname' => $data['user_lastname'] ?? '',
                'user_birth_date' => $data['user_birth_date'] ?? '',
                'user_sex' => $data['user_sex'] ?? '',
                'user_phone' => $data['user_phone'] ?? '',
                'user_email' => $data['user_email'] ?? '',
                'user_password' => password_hash($plain_password, PASSWORD_DEFAULT)
            ]);

            $lastUserId = $this->getLastUserId();
            if ($lastUserId === null) {
                return ["success" => false, "message" => "Impossible de récupérer l'ID du nouvel utilisateur"];
            }

            // Ajouter dans personals ou teachers selon la page
            if ($_SESSION['page'] === "add-personal") {
                $sql3 = "INSERT INTO personals (user_id, place_id) VALUES (:user_id, :place_id)";
                $query3 = $db->prepare($sql3);
                $query3->execute([
                    'user_id' => $lastUserId,
                    'place_id' => $data['place_id'] ?? null
                ]);
            } elseif ($_SESSION['page'] === "add-teacher") {
                $sql4 = "INSERT INTO teachers (user_id) VALUES (:user_id)";
                $query4 = $db->prepare($sql4);
                $query4->execute([
                    'user_id' => $lastUserId
                ]);
            } elseif ($_SESSION['page'] === "add-student") {
                function generateMatricule($database) {
                    $prefix = "EDCGSC";

                    // Récupérer le dernier matricule enregistré
                    $query5 = $database->query("SELECT student_matricule FROM students ORDER BY student_matricule DESC LIMIT 1");
                    $lastMatricule = $query5->fetchColumn();

                    if ($lastMatricule) {
                        // Extraire la partie numérique
                        $number = (int)substr($lastMatricule, strlen($prefix));
                        $number++; // incrémenter
                    } else {
                        $number = 1; // si aucun matricule, commencer à 1
                    }

                    // Formater avec 4 chiffres et concaténer le préfixe
                    $newMatricule = $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);

                    return $newMatricule;
                }

                $sql6 = "INSERT INTO students (
                    user_id, 
                    parent_id, 
                    year_id, 
                    place_id, 
                    cycle_id,
                    level_id, 
                    serie_id,
                    room_id,
                    student_matricule
                ) VALUES (
                    :user_id, 
                    :parent_id, 
                    :year_id, 
                    :place_id, 
                    :cycle_id,
                    :level_id, 
                    :serie_id,
                    :room_id,
                    :student_matricule
                )";
                $query6 = $db->prepare($sql6);
                $query6->execute([
                    'user_id' => $lastUserId,
                    'parent_id' => $data['parent_id'] ?? null,
                    'year_id' => $_SESSION['year_id'] ?? null,
                    'place_id' => $data['place_id'] ?? null,
                    'cycle_id' => $_SESSION['cycle_id'] ?? null,
                    'level_id' => $data['level_id'] ?? null,
                    'serie_id' => $data['serie_id'] ?? null,
                    'room_id' => $data['room_id'] ?? null,
                    'student_matricule' => generateMatricule($db) ?? null
                ]);
            } elseif ($_SESSION['page'] === "add-parent") {
                // Aucun ajout supplémentaire nécessaire pour les parents
                $sql8 = "INSERT INTO parents (user_id) VALUES (:user_id)";
                $query8 = $db->prepare($sql8);
                $query8->execute([
                    'user_id' => $lastUserId
                ]);
            }

            // Log JSON
            $logDir = __DIR__ . '/../logs';
            if (!is_dir($logDir)) mkdir($logDir, 0775, true);

            $logFile = $logDir . '/user-password.json';
            $entry = [
                'user_email' => $data['user_email'] ?? '',
                'user_firstname' => $data['user_firstname'] ?? '',
                'user_lastname' => $data['user_lastname'] ?? '',
                'plain_password' => $plain_password,
                'date' => date('Y-m-d H:i:s')
            ];

            $all = [];
            if (file_exists($logFile)) {
                $all = json_decode(file_get_contents($logFile), true) ?: [];
            }
            $all[] = $entry;
            file_put_contents($logFile, json_encode($all, JSON_PRETTY_PRINT));

            return [
                "success" => true,
                "message" => "Utilisateur ajouté avec succès !",
                "plain_password" => $plain_password
            ];

        } catch (Exception $e) {
            $msg = $e->getMessage();
            if (strpos($msg, 'Duplicate entry') !== false) {
                if (strpos($msg, 'user_phone') !== false) $msg = "Ce numéro de téléphone a déjà été utilisé.";
                elseif (strpos($msg, 'user_email') !== false) $msg = "Cette adresse email a déjà été utilisée.";
                else $msg = "Un champ unique a déjà été utilisé.";
            }
            return ["success" => false, "message" => $msg];
        }
    }

    public function reinscription($data)
    {
        try {
            $db = $this->Database();

            if ($_SESSION['page'] === "reinscription-student") {
                $sql = "INSERT INTO reinscriptions (
                            student_id,  
                            year_id, 
                            place_id,
                            level_id, 
                            serie_id,
                            room_id
                        ) VALUES (
                            :student_id,  
                            :year_id, 
                            :place_id,
                            :level_id, 
                            :serie_id,
                            :room_id
                        )";

                $query = $db->prepare($sql);
                $query->execute([
                    'student_id' => $data['student_id'],
                    'year_id' => $_SESSION['year_id'] ?? null,
                    'place_id' => $data['place_id'] ?? null,
                    'level_id' => $data['level_id'] ?? null,
                    'serie_id' => $data['serie_id'] ?? null,
                    'room_id' => $data['room_id'] ?? null
                ]);

                return [
                    'success' => true,
                    'message' => "Réinscription effectuée avec succès."
                ];
            } else {
                return [
                    'success' => false,
                    'message' => "Page non autorisée pour la réinscription."
                ];
            }

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => "Erreur lors de la réinscription : " . $e->getMessage()
            ];
        }
    }



    public function updateUser($data)
    {
        try {
            $db = $this->Database();

            if ($_SESSION['page'] === "edit-personal") {
                $sql1 = "UPDATE users SET 
                    role_id = :role_id,
                    user_firstname = :user_firstname,
                    user_lastname = :user_lastname,
                    user_birth_date = :user_birth_date,
                    user_sex = :user_sex,
                    user_phone = :user_phone,
                    user_email = :user_email
                    WHERE user_id = :user_id";
                $query1 = $db->prepare($sql1);
                $query1->execute([
                    'user_id' => $data['user_id'],
                    'role_id' => $data['role_id'],
                    'user_firstname' => $data['user_firstname'],
                    'user_lastname' => $data['user_lastname'],
                    'user_birth_date' => $data['user_birth_date'],
                    'user_sex' => $data['user_sex'],
                    'user_phone' => $data['user_phone'],
                    'user_email' => $data['user_email']
                ]);

                $sql2 = "UPDATE personals SET place_id = :place_id WHERE user_id = :user_id";
                $query2 = $db->prepare($sql2);
                $query2->execute([
                    'user_id' => $data['user_id'],
                    'place_id' => $data['place_id']
                ]);
            } elseif ($_SESSION['page'] === "edit-teacher") {
                $sql1 = "UPDATE users SET 
                    user_firstname = :user_firstname,
                    user_lastname = :user_lastname,
                    user_birth_date = :user_birth_date,
                    user_sex = :user_sex,
                    user_phone = :user_phone,
                    user_email = :user_email
                    WHERE user_id = :user_id";
                $query1 = $db->prepare($sql1);
                $query1->execute([
                    'user_id' => $data['user_id'],
                    'user_firstname' => $data['user_firstname'],
                    'user_lastname' => $data['user_lastname'],
                    'user_birth_date' => $data['user_birth_date'],
                    'user_sex' => $data['user_sex'],
                    'user_phone' => $data['user_phone'],
                    'user_email' => $data['user_email']
                ]);
            } elseif ($_SESSION['page'] === "edit-parent"){
                $sql1 = "UPDATE users SET 
                    user_firstname = :user_firstname,
                    user_lastname = :user_lastname,
                    user_birth_date = :user_birth_date,
                    user_sex = :user_sex,
                    user_phone = :user_phone,
                    user_email = :user_email
                    WHERE user_id = :user_id";
                $query1 = $db->prepare($sql1);
                $query1->execute([
                    'user_id' => $data['user_id'],
                    'user_firstname' => $data['user_firstname'],
                    'user_lastname' => $data['user_lastname'],
                    'user_birth_date' => $data['user_birth_date'],
                    'user_sex' => $data['user_sex'],
                    'user_phone' => $data['user_phone'],
                    'user_email' => $data['user_email']
                ]);
            } elseif ($_SESSION['page'] === "edit-student") {
                $sql1 = "UPDATE users SET 
                    user_firstname = :user_firstname,
                    user_lastname = :user_lastname,
                    user_birth_date = :user_birth_date,
                    user_sex = :user_sex,
                    user_phone = :user_phone,
                    user_email = :user_email
                    WHERE user_id = :user_id";
                $query1 = $db->prepare($sql1);
                $query1->execute([
                    'user_id' => $data['user_id'],
                    'user_firstname' => $data['user_firstname'],
                    'user_lastname' => $data['user_lastname'],
                    'user_birth_date' => $data['user_birth_date'],
                    'user_sex' => $data['user_sex'],
                    'user_phone' => $data['user_phone'],
                    'user_email' => $data['user_email']
                ]);

                $sql2 = "UPDATE students SET 
                    parent_id = :parent_id,
                    place_id = :place_id,
                    level_id = :level_id
                    WHERE user_id = :user_id";
                $query2 = $db->prepare($sql2);
                $query2->execute([
                    'user_id' => $data['user_id'],
                    'parent_id' => $data['parent_id'],
                    'place_id' => $data['place_id'],
                    'level_id' => $data['level_id']
                ]);
            }

            return ["success" => true, "message" => "Utilisateur modifié avec succès !"];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function deleteUser($user_id)
    {
        try {
            $db = $this->Database();
            $sql = "DELETE FROM users WHERE user_id = :user_id";
            $query = $db->prepare($sql);
            $query->execute(['user_id' => $user_id]);
            return ["success" => true, "message" => "Utilisateur supprimé avec succès."];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    /**
 * Renvoie les élèves inscrits et réinscrits filtrés par user_adder_id, year_id et role_name.
 *
 * @param string $roleName    Le rôle à filtrer (ex: 'Apprenant')
 * @param int|null $yearId    Année à filtrer (si null, prend $_SESSION['year_id'])
 * @param int|null $userAdderId User qui a ajouté les élèves (si null, prend $_SESSION['user_id'])
 * @return array
 */

    public function selectAllUsersByRole(string $roleName, ?int $yearId = null, ?int $userAdderId = null): array
    {
        $db = $this->Database();

        $userAdderId = $userAdderId ?? ($_SESSION['user_id'] ?? null);
        $yearId = $yearId ?? ($_SESSION['year_id'] ?? null);

        // On prépare la requête selon le rôle demandé
        switch ($roleName) {

            case 'Apprenant':
                $sql = "
                    SELECT 
                        s.student_id,
                        s.student_matricule,
                        u.user_id,
                        u.user_lastname,
                        u.user_firstname,
                        u.user_email,
                        u.user_birth_date,
                        u.user_sex,
                        y.year_name,
                        p.place_name,
                        c.cycle_name,
                        le.level_name,
                        se.serie_name,
                        s.student_date_add,
                        'Inscription' AS inscription_type
                    FROM students s
                    INNER JOIN users u ON s.user_id = u.user_id
                    INNER JOIN roles r ON u.role_id = r.role_id
                    INNER JOIN years y ON s.year_id = y.year_id
                    INNER JOIN places p ON s.place_id = p.place_id
                    INNER JOIN cycles c ON s.cycle_id = c.cycle_id
                    INNER JOIN levels le ON s.level_id = le.level_id
                    INNER JOIN series se ON s.serie_id = se.serie_id
                    WHERE u.user_adder_id = :user_adder_id
                    AND r.role_name = :role_name
                    AND s.year_id = :year_id

                    UNION ALL

                    SELECT 
                        s.student_id,
                        s.student_matricule,
                        u.user_id,
                        u.user_lastname,
                        u.user_firstname,
                        u.user_email,
                        u.user_birth_date,
                        u.user_sex,
                        y.year_name,
                        p.place_name,
                        c.cycle_name,
                        le.level_name,
                        se.serie_name,
                        s.student_date_add,
                        'Réinscription' AS inscription_type
                    FROM reinscriptions re
                    INNER JOIN students s ON re.student_id = s.student_id
                    INNER JOIN users u ON s.user_id = u.user_id
                    INNER JOIN roles r ON u.role_id = r.role_id
                    INNER JOIN years y ON re.year_id = y.year_id
                    INNER JOIN places p ON re.place_id = p.place_id
                    INNER JOIN cycles c ON s.cycle_id = c.cycle_id
                    INNER JOIN levels le ON re.level_id = le.level_id
                    INNER JOIN series se ON re.serie_id = se.serie_id
                    WHERE u.user_adder_id = :user_adder_id
                    AND r.role_name = :role_name
                    AND re.year_id = :year_id

                    ORDER BY user_lastname ASC, user_firstname ASC
                ";
                $params = [
                    'user_adder_id' => $userAdderId,
                    'role_name'     => $roleName,
                    'year_id'       => $yearId
                ];
                break;

            case 'Enseignant':
                $sql = "
                    SELECT 
                        u.user_id,
                        u.user_firstname,
                        u.user_lastname,
                        u.user_email,
                        u.user_phone,
                        u.user_birth_date,
                        u.user_sex,
                        u.user_date_add,
                        r.role_name
                    FROM users u
                    INNER JOIN roles r ON u.role_id = r.role_id
                    INNER JOIN teachers t ON u.user_id = t.user_id
                    WHERE u.user_adder_id = :user_adder_id
                    AND r.role_name = :role_name
                    ORDER BY u.user_lastname ASC
                ";
                $params = [
                    'user_adder_id' => $userAdderId,
                    'role_name'     => $roleName
                ];
                break;

            case 'Parent':
                $sql = "
                    SELECT 
                        u.user_id,
                        u.user_firstname,
                        u.user_lastname,
                        u.user_email,
                        u.user_phone,
                        u.user_birth_date,
                        u.user_sex,
                        u.user_date_add,
                        r.role_name
                    FROM users u
                    INNER JOIN roles r ON u.role_id = r.role_id
                    INNER JOIN parents pa ON u.user_id = pa.user_id
                    WHERE u.user_adder_id = :user_adder_id
                    AND r.role_name = :role_name
                    ORDER BY u.user_lastname ASC
                ";
                $params = [
                    'user_adder_id' => $userAdderId,
                    'role_name'     => $roleName
                ];
                break;

            default: // Personnels ou autres
                $sql = "
                    SELECT 
                        u.user_id,
                        u.user_firstname,
                        u.user_lastname,
                        u.user_email,
                        u.user_phone,
                        u.user_birth_date,
                        u.user_sex,
                        u.user_date_add,
                        r.role_name,
                        p.place_name
                    FROM users u
                    INNER JOIN roles r ON u.role_id = r.role_id
                    INNER JOIN personals ps ON u.user_id = ps.user_id
                    INNER JOIN places p ON ps.place_id = p.place_id
                    WHERE u.user_adder_id = :user_adder_id
                    AND r.role_name = :role_name
                    ORDER BY u.user_lastname ASC
                ";
                $params = [
                    'user_adder_id' => $userAdderId,
                    'role_name'     => $roleName
                ];
        }

        $query = $db->prepare($sql);
        $query->execute($params);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectTeachers(): array
    {
        return $this->selectAllUsersByRole('Enseignant');
    }

    public function selectStudents(): array
    {
        return $this->selectAllUsersByRole('Apprenant');
    }

    public function selectParents(): array
    {
        return $this->selectAllUsersByRole('Parent');
    }

    public function selectUserById($user_id)
    {
        $db = $this->Database();
        $sql = "SELECT * FROM users, students 
            WHERE users.user_id = :user_id";
        $query = $db->prepare($sql);
        $query->execute(['user_id' => $user_id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function selectUserRoleId($role_name)
    {
        $db = $this->Database();
        $sql = "SELECT role_id FROM roles WHERE role_name = :role_name";
        $query = $db->prepare($sql);
        $query->execute(['role_name' => $role_name]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function selectAllTeachers (): array
    {
        $db = $this->Database();

        $sql = "SELECT 
                    t.teacher_id,
                    u.user_firstname,
                    u.user_lastname,
                    u.user_email
                FROM teachers t
                JOIN users u ON t.user_id = u.user_id
                ORDER BY u.user_lastname ASC";

        $query = $db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectAllParents (): array
    {
        $db = $this->Database();

        $sql = "SELECT 
                    pa.parent_id,
                    u.user_firstname,
                    u.user_lastname,
                    u.user_email
                FROM parents pa
                JOIN users u ON pa.user_id = u.user_id
                ORDER BY u.user_lastname ASC";

        $query = $db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function selectUserPersonals (): array
    {
        $db = $this->Database();

        $sql = "SELECT 
                        u.user_id,
                        u.user_firstname,
                        u.user_lastname,
                        u.user_email,
                        u.user_phone,
                        u.user_birth_date,
                        u.user_sex,
                        u.user_date_add,
                        r.role_name,
                        p.place_name
                    FROM users u
                    INNER JOIN roles r ON u.role_id = r.role_id
                    INNER JOIN personals ps ON u.user_id = ps.user_id
                    INNER JOIN places p ON ps.place_id = p.place_id
                    WHERE u.user_adder_id = " . $_SESSION['user_id'];

        $query = $db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectPlacesByTeacherSchedules(): array
    {
        $db = $this->Database();

        $sql = "SELECT DISTINCT
                    u.user_id,
                    u.user_firstname,
                    u.user_lastname,
                    r.role_name,
                    p.place_name,
                    p.place_id,
                    y.year_name,
                    y.year_id,
                    c.cycle_id,
                    c.cycle_name,
                    le.level_name
                FROM users u
                INNER JOIN roles r ON u.role_id = r.role_id
                INNER JOIN teachers t ON u.user_id = t.user_id
                LEFT JOIN schedules sh ON t.teacher_id = sh.teacher_id
                LEFT JOIN places p ON sh.place_id = p.place_id
                LEFT JOIN years y ON sh.year_id = y.year_id
                LEFT JOIN cycles c ON sh.cycle_id = c.cycle_id
                LEFT JOIN levels le ON sh.level_id = le.level_id
                WHERE u.user_id = :user_id";

        $query = $db->prepare($sql);
        $query->execute([':user_id' => $_SESSION['user_id']]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}