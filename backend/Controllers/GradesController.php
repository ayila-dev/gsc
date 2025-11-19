<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class GradesController
{
     private $host = "localhost";
     private $dbname = "db_gsc";
     private $username = "gsc";
     private $password = "gsc";

     private function Database()
     {
          try {
               $connect = new PDO(
                    'mysql:host=' . $this->host . ';dbname=' . $this->dbname,
                    $this->username,
                    $this->password
               );
               return $connect;
          } catch (PDOException $e) {
               die("Connexion échouée" . $e->getMessage());
          }
     }

    public function selectAllStudentByParams() 
    {
        $db = $this->Database();

        $sql = "SELECT 
                s.student_id,
                s.student_matricule,
                u.user_firstname,
                u.user_lastname,

                s.year_id,
                s.place_id,
                s.cycle_id,
                s.level_id,
                s.serie_id,
                s.room_id

            FROM users u
            JOIN students s ON s.user_id = u.user_id

            WHERE s.year_id = :year_id
            AND s.place_id = :place_id
            AND s.cycle_id = :cycle_id
            AND s.level_id = :level_id
            AND s.serie_id = :serie_id
            AND s.room_id = :room_id";

        $query = $db->prepare($sql);

        $query->execute([
            ':year_id'  => $_SESSION['year_id'],
            ':place_id' => $_SESSION['place_id'],
            ':cycle_id' => $_SESSION['cycle_id'],
            ':level_id' => $_SESSION['level_id'],
            ':serie_id' => $_SESSION['serie_id'],
            ':room_id'  => $_SESSION['room_id']
        ]);
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* public function addGrade($data)
    {
        // Vérifie que la période et le type d’évaluation sont présents
        if (empty($data['grade_period']) || empty($data['grade_type'])) {
            return ["success" => false, "message" => "La période et le type d'évaluation sont requis"];
        }

        $grade_period = $data['grade_period'];
        $grade_type   = $data['grade_type'];

        $_SESSION['grade_period'] = $data['grade_period'];

        // Vérification des paramètres de la session
        $year_id  = $_SESSION['year_id']  ?? null;
        $place_id = $_SESSION['place_id'] ?? null;
        $cycle_id = $_SESSION['cycle_id'] ?? null;
        $level_id = $_SESSION['level_id'] ?? null;
        $serie_id = $_SESSION['serie_id'] ?? null;
        $room_id  = $_SESSION['room_id']  ?? null;

        if (!$year_id || !$place_id || !$cycle_id || !$level_id || !$serie_id || !$room_id) {
            return ["success" => false, "message" => "Paramètres manquants pour filtrer les étudiants"];
        }

        // Récupère les étudiants filtrés
        $students = $this->selectAllStudentByParams();

        if (empty($students)) {
            return ["success" => false, "message" => "Aucun étudiant trouvé pour ces paramètres"];
        }

        // Associe le type d'évaluation à la bonne colonne SQL
        $columns = [
            'i1' => 'grade_first_interro',
            'i2' => 'grade_second_interro',
            'i3' => 'grade_third_interro',
            'd1' => 'grade_first_duty',
            'd2' => 'grade_second_duty'
        ];

        if (!isset($columns[$grade_type])) {
            return ["success" => false, "message" => "Type d'évaluation inconnu"];
        }

        $column = $columns[$grade_type];

        try {
            $db = $this->Database();
            $db->beginTransaction();

            $i = 1;

            foreach ($students as $student) {

                // Récupération de la note inputée
                $grade_value = $data["grade{$i}"] ?? null;

                if ($grade_value === null || !is_numeric($grade_value)) {
                    $db->rollBack();
                    return [
                        "success" => false,
                        "message" => "La note pour {$student['user_firstname']} {$student['user_lastname']} est invalide"
                    ];
                }

               // Vérifie si une ligne existe déjà
                $check = $db->prepare("
                    SELECT grade_id 
                    FROM grades 
                    WHERE student_id = :student_id 
                    AND course_id = :course_id
                    AND grade_period = :grade_period
                ");
                $check->execute([
                    ':student_id'   => $student['student_id'],
                    ':course_id'    => $_SESSION['course_id'],
                    ':grade_period' => $_SESSION['grade_period']
                ]);

                $existing = $check->fetch();

                // -------------------------------------------
                // 1) SI UNE LIGNE EXISTE → UPDATE
                // -------------------------------------------
                if ($existing) {
                    $sql = "UPDATE grades 
                            SET $column = :grade_value 
                            WHERE grade_id = :grade_id";

                    $stmt = $db->prepare($sql);
                    $stmt->execute([
                        ':grade_value' => $grade_value,
                        ':grade_id'    => $existing['grade_id']
                    ]);

                } else {

                    // -------------------------------------------
                    // 2) SINON → INSERT
                    // -------------------------------------------
                    $sql = "INSERT INTO grades 
                            (course_id, student_id, grade_period, $column)
                            VALUES (:course_id, :student_id, :grade_period, :grade_value)";

                    $stmt = $db->prepare($sql);
                    $stmt->execute([
                        ':course_id'    => $_SESSION['course_id'],
                        ':student_id'   => $student['student_id'],
                        ':grade_period' => $_SESSION['grade_period'],
                        ':grade_value'  => $grade_value
                    ]);
                }
                $i++;
            }

            $db->commit();
            return ["success" => true, "message" => "Notes ajoutées avec succès"];

        } catch (PDOException $e) {
            $db->rollBack();
            return ["success" => false, "message" => "Erreur DB : " . $e->getMessage()];
        }
    } */

    public function addGrade($data)
{
    // 1️⃣ Vérification de la période et du type d'évaluation
    if (empty($data['grade_period']) || empty($data['grade_type'])) {
        return ["success" => false, "message" => "La période et le type d'évaluation sont requis"];
    }

    $grade_period = $data['grade_period'];
    $grade_type   = $data['grade_type'];
    $_SESSION['grade_period'] = $grade_period;

    // 2️⃣ Vérification des paramètres de session pour filtrer les étudiants
    $year_id  = $_SESSION['year_id'] ?? null;
    $place_id = $_SESSION['place_id'] ?? null;
    $cycle_id = $_SESSION['cycle_id'] ?? null;
    $level_id = $_SESSION['level_id'] ?? null;
    $serie_id = $_SESSION['serie_id'] ?? null;
    $room_id  = $_SESSION['room_id'] ?? null;

    if (!$year_id || !$place_id || !$cycle_id || !$level_id || !$serie_id || !$room_id) {
        return ["success" => false, "message" => "Paramètres manquants pour filtrer les étudiants"];
    }

    // 3️⃣ Récupération des étudiants filtrés
    $students = $this->selectAllStudentByParams();
    if (empty($students)) {
        return ["success" => false, "message" => "Aucun étudiant trouvé pour ces paramètres"];
    }

    // 4️⃣ Association type d'évaluation -> colonne SQL
    $columns = [
        'i1' => 'grade_first_interro',
        'i2' => 'grade_second_interro',
        'i3' => 'grade_third_interro',
        'd1' => 'grade_first_duty',
        'd2' => 'grade_second_duty'
    ];

    if (!isset($columns[$grade_type])) {
        return ["success" => false, "message" => "Type d'évaluation inconnu"];
    }
    $column = $columns[$grade_type];

    try {
        $db = $this->Database();
        $db->beginTransaction();

        $i = 1;

        foreach ($students as $student) {
            $grade_value = $data["grade{$i}"] ?? null;

            if ($grade_value === null || !is_numeric($grade_value)) {
                $db->rollBack();
                return [
                    "success" => false,
                    "message" => "La note pour {$student['user_firstname']} {$student['user_lastname']} est invalide"
                ];
            }

            // 5️⃣ Vérifie si une ligne de notes existe déjà pour la période et le cours
            $check = $db->prepare("
                SELECT * 
                FROM grades 
                WHERE student_id = :student_id
                AND course_id = :course_id
                AND grade_period = :grade_period
            ");
            $check->execute([
                ':student_id'   => $student['student_id'],
                ':course_id'    => $_SESSION['course_id'],
                ':grade_period' => $_SESSION['grade_period']
            ]);

            $existing = $check->fetch(PDO::FETCH_ASSOC);

            // 6️⃣ Si ligne existe → vérifier si la colonne du type choisi est déjà remplie
            if ($existing) {
                if (!is_null($existing[$column])) {
                    $db->rollBack();
                    return [
                        "success" => false,
                        "message" => "La note {$grade_type} existe déjà pour tout vos apprenants"
                    ];
                }

                // Mise à jour de la colonne spécifique
                $sql = "UPDATE grades SET $column = :grade_value WHERE grade_id = :grade_id";
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    ':grade_value' => $grade_value,
                    ':grade_id'    => $existing['grade_id']
                ]);

            } else {
                // 7️⃣ Vérification : la période précédente doit être complète avant insertion
                $previous_complete = $db->prepare("
                    SELECT * FROM grades
                    WHERE student_id = :student_id
                    AND course_id = :course_id
                    ORDER BY grade_period DESC
                    LIMIT 1
                ");
                $previous_complete->execute([
                    ':student_id' => $student['student_id'],
                    ':course_id'  => $_SESSION['course_id']
                ]);
                $prev = $previous_complete->fetch(PDO::FETCH_ASSOC);

                if ($prev) {
                    $needed_columns = ['grade_first_interro','grade_second_interro','grade_third_interro','grade_first_duty','grade_second_duty'];
                    foreach ($needed_columns as $col) {
                        if (is_null($prev[$col])) {
                            $db->rollBack();
                            return [
                                "success" => false,
                                "message" => "Impossible d'ajouter une nouvelle période pour {$student['user_firstname']} {$student['user_lastname']}, la période précédente n'est pas complète"
                            ];
                        }
                    }
                }

                // Insert de la nouvelle ligne pour cette période
                $sql = "INSERT INTO grades (course_id, student_id, grade_period, $column)
                        VALUES (:course_id, :student_id, :grade_period, :grade_value)";
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    ':course_id'    => $_SESSION['course_id'],
                    ':student_id'   => $student['student_id'],
                    ':grade_period' => $_SESSION['grade_period'],
                    ':grade_value'  => $grade_value
                ]);
            }

            $i++;
        }

        $db->commit();
        return ["success" => true, "message" => "Notes ajoutées avec succès"];

    } catch (PDOException $e) {
        $db->rollBack();
        return ["success" => false, "message" => "Erreur DB : " . $e->getMessage()];
    }
}


    public function selectAllGradesByParams()
    {
        $db = $this->Database();

        $sql = "SELECT 
                    g.grade_id,
                    g.grade_first_interro,
                    g.grade_second_interro,
                    g.grade_third_interro,
                    g.grade_first_duty,
                    g.grade_second_duty,
                    g.grade_period,

                    c.course_id,
                    c.course_name,
                    c.course_coef,

                    s.student_id,
                    s.student_matricule,

                    u.user_id,
                    u.user_firstname,
                    u.user_lastname,

                    l.level_name,
                    se.serie_name

                FROM grades g
                JOIN students s  ON g.student_id = s.student_id
                JOIN users u     ON s.user_id = u.user_id
                JOIN levels l    ON s.level_id = l.level_id
                JOIN series se   ON s.serie_id = se.serie_id
                JOIN courses c   ON g.course_id = c.course_id

                WHERE s.year_id  = :year_id
                AND s.place_id   = :place_id
                AND s.cycle_id   = :cycle_id
                AND s.level_id   = :level_id
                AND s.serie_id   = :serie_id
                AND s.room_id    = :room_id

                ORDER BY u.user_lastname ASC, c.course_name ASC";

        $query = $db->prepare($sql);

        $query->execute([
            ':year_id'  => $_SESSION['year_id'],
            ':place_id' => $_SESSION['place_id'],
            ':cycle_id' => $_SESSION['cycle_id'],
            ':level_id' => $_SESSION['level_id'],
            ':serie_id' => $_SESSION['serie_id'],
            ':room_id'  => $_SESSION['room_id']
        ]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReportCard($data)
    {
        try {
            $db = $this->Database();

            $sql = "SELECT 
                        s.student_id,
                        s.student_matricule,
                        
                        u.user_lastname,
                        u.user_firstname,
                        u.user_birth_date,
                        u.user_sex,
                        
                        le.level_id,
                        le.level_name,

                        se.serie_id,
                        se.serie_name,

                        r.room_id,
                        r.room_name,
                        
                        c.course_id,
                        c.course_name,
                        c.course_coef,

                        g.grade_period,
                        g.grade_first_interro,
                        g.grade_second_interro,
                        g.grade_third_interro,
                        g.grade_first_duty,
                        g.grade_second_duty,

                        y.year_name,

                        (
                            SELECT COUNT(*) 
                            FROM students st
                            WHERE st.room_id = :room_id
                        ) AS total_students

                    FROM grades g
                    INNER JOIN students s ON g.student_id = s.student_id
                    INNER JOIN users u ON s.user_id = u.user_id
                    INNER JOIN courses c ON g.course_id = c.course_id

                    INNER JOIN levels le ON s.level_id = le.level_id
                    INNER JOIN series se ON s.serie_id = se.serie_id
                    INNER JOIN rooms r ON s.room_id = r.room_id
                    INNER JOIN places p ON s.place_id = p.place_id
                    INNER JOIN years y ON y.year_id = s.year_id

                    WHERE g.grade_period = :period
                    AND s.place_id = :place_id
                    AND s.level_id = :level_id
                    AND s.serie_id = :serie_id
                    AND s.room_id = :room_id

                    ORDER BY u.user_lastname, c.course_name ASC
            ";

            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':place_id' => $data['place_id'],
                ':level_id' => $data['level_id'],
                ':serie_id' => $data['serie_id'],
                ':room_id'  => $data['room_id'],
                ':period'   => $data['grade_period']
            ]);

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($rows)) {
                return [
                    "success" => false,
                    "message" => "Aucune note trouvée pour ces paramètres."
                ];
            }

            return [
                "success" => true,
                "data" => $rows
            ];

        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Erreur DB : " . $e->getMessage()
            ];
        }
    }

}
