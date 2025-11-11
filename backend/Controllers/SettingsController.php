<?php
class SettingsController
{
    private $host = "localhost";
    private $dbname = "db_gsc";
    private $username = "gsc";
    private $password = "gsc";

    private function Database(): PDO
    {
        try {
            $connect = new PDO(
                dsn: 'mysql:host=' . $this->host . ';dbname=' . $this->dbname,
                username: $this->username,
                password: $this->password
            );
            return $connect;
        } catch (PDOException $e) {
            die("Connexion échouée" . $e->getMessage());
        }
    }

    ######################################## Years ########################################

    /**
     * Function to add Year
     * @var string $year_name
     */
    public function addYear($data)
    {
        try {
            $db = $this->Database();
            $sql = "INSERT INTO years (year_name) VALUES (:year_name)";
            $query = $db->prepare( $sql);
            $query->execute( [
                'year_name' => $data['year_name'] ?? ''
            ]);

            return [
                "success" => true, 
                "message" => "Année Scolaire ajoutée avec succès !"
            ];
        } catch (Exception $e) {
            $msg = $e->getMessage();
            // Gestion des erreurs de doublon (Année Scolaire)
            if (strpos($msg, 'Duplicate entry') !== false) {
                if (strpos($msg, 'year_name') !== false) {
                    $msg = "Cette année avait déjà été ajoutée.";
                } else {
                    $msg = "Un champ unique a déjà été utilisée.";
                }
            }
            return [
                "success" => false, 
                "message" => $msg
            ];
        }
    }


    /**
     * Function to update years by ID.
     * @var string $year_name
     */
    public function updateYear($data)
    {
        try {
            $db = $this->Database();
            $sql = "UPDATE years SET 
                year_name = :year_name
                WHERE year_id = :year_id";
            $query = $db->prepare($sql);
            $query->execute([
                'year_name' => $data['year_name'],
                'year_id' => $data['year_id']
            ]);
            return [
                "success" => true, 
                "message" => "Année scolaire modifiée avec succès !"
            ];
        } catch (Exception $e) {
            return [
                "success" => false, 
                "message" => $e->getMessage()
            ];
        }
    }


    /**
     * Function to delete year by ID.
     * @param int $year_id
     */
    public function deleteYear($year_id)
    {
        try {
            $db = $this->Database();
            $sql = "DELETE FROM years WHERE year_id = :year_id";
            $query = $db->prepare(query: $sql);
            $query->execute(params: ['year_id' => $year_id]);
            return [
                "success" => true,
                "message" => "Année scolaire supprimée avec succès."
            ];
        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    /**
     * Function to select all years.
     * @return array
     */
    public function selectAllYears(): array
    {
        $db = $this->Database();
        $sql = "SELECT * FROM years";
        $query = $db->query(query: $sql);
        return $query->fetchAll();
    }

    /**
     * Function to select year by id.
     * @return array
     */
    public function selectYearById($year_id): mixed
    {
        $db = $this->Database();
        $sql = "SELECT * FROM years WHERE year_id = :year_id";
        $query = $db->prepare(query: $sql);
        $query->execute(params: ['year_id' => $year_id]);
        return $query->fetch();
    }

    ######################################## Places ########################################

    /**
     * Function to add Place
     * @var string $place_name
     */
    public function addPlace($data)
    {
        try {
            $db = $this->Database();
            $sql = "INSERT INTO places (place_name) VALUES (:place_name)";
            $query = $db->prepare( $sql);
            $query->execute( [
                'place_name' => $data['place_name'] ?? ''
            ]);

            return [
                "success" => true, 
                "message" => "Centre ajouté avec succès !"
            ];
        } catch (Exception $e) {
            $msg = $e->getMessage();
            // Duplicate error manage (Place)
            if (strpos($msg, 'Duplicate entry') !== false) {
                if (strpos($msg, 'place_name') !== false) {
                    $msg = "Ce centre avait déjà été ajouté.";
                } else {
                    $msg = "Un champ unique a déjà été utilisé.";
                }
            }
            return [
                "success" => false, 
                "message" => $msg
            ];
        }
    }


    /**
     * Function to update places by ID.
     * @var string $place_name
     */
    public function updatePlace($data)
    {
        try {
            $db = $this->Database();
            $sql = "UPDATE places SET 
                place_name = :place_name
                WHERE place_id = :place_id";
            $query = $db->prepare($sql);
            $query->execute([
                'place_name' => $data['place_name'],
                'place_id' => $data['place_id']
            ]);
            return [
                "success" => true, 
                "message" => "Centre modifié avec succès !"
            ];
        } catch (Exception $e) {
            return [
                "success" => false, 
                "message" => $e->getMessage()
            ];
        }
    }


    /**
     * Function to delete place by ID.
     * @param int $place_id
     */
    public function deletePlace($place_id)
    {
        try {
            $db = $this->Database();
            $sql = "DELETE FROM places WHERE place_id = :place_id";
            $query = $db->prepare($sql);
            $query->execute(['place_id' => $place_id]);
            return [
                "success" => true,
                "message" => "Centre supprimé avec succès."
            ];
        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    /**
     * Function to select all places.
     * @return array
     */
    public function selectAllPlaces(): array
    {
        $db = $this->Database();
        $sql = "SELECT * FROM places";
        $query = $db->query(query: $sql);
        return $query->fetchAll();
    }

    /**
     * Function to select place by id.
     * @return array
     */
    public function selectPlaceById($place_id): mixed
    {
        $db = $this->Database();
        $sql = "SELECT * FROM places WHERE place_id = :place_id";
        $query = $db->prepare(query: $sql);
        $query->execute(params: ['place_id' => $place_id]);
        return $query->fetch();
    }

    ######################################## Cycles ########################################

    /**
     * Function to add Cycle
     * @var string $cycle_name
     */
    public function addCycle($data)
    {
        try {
            $db = $this->Database();
            $sql = "INSERT INTO cycles (cycle_name) VALUES (:cycle_name)";
            $query = $db->prepare( $sql);
            $query->execute( [
                'cycle_name' => $data['cycle_name'] ?? ''
            ]);

            return [
                "success" => true, 
                "message" => "Cycle ajouté avec succès !"
            ];
        } catch (Exception $e) {
            $msg = $e->getMessage();
            // Duplicate error manage (Cycle)
            if (strpos($msg, 'Duplicate entry') !== false) {
                if (strpos($msg, 'cycle_name') !== false) {
                    $msg = "Ce Cycle avait déjà été ajouté.";
                } else {
                    $msg = "Un champ unique a déjà été utilisé.";
                }
            }
            return [
                "success" => false, 
                "message" => $msg
            ];
        }
    }

    /**
     * Function to update cycles by ID.
     * @var string $cycle_name
     */
    public function updateCycle($data)
    {
        try {
            $db = $this->Database();
            $sql = "UPDATE cycles SET 
                cycle_name = :cycle_name
                WHERE cycle_id = :cycle_id";
            $query = $db->prepare($sql);
            $query->execute([
                'cycle_name' => $data['cycle_name'],
                'cycle_id' => $data['cycle_id']
            ]);
            return [
                "success" => true, 
                "message" => "Cycle modifié avec succès !"
            ];
        } catch (Exception $e) {
            return [
                "success" => false, 
                "message" => $e->getMessage()
            ];
        }
    }

    /**
     * Function to delete cycle by ID.
     * @param int $cycle_id
     */
    public function deleteCycle($cycle_id)
    {
        try {
            $db = $this->Database();
            $sql = "DELETE FROM cycles WHERE cycle_id = :cycle_id";
            $query = $db->prepare($sql);
            $query->execute(['cycle_id' => $cycle_id]);
            return [
                "success" => true,
                "message" => "Cycle supprimé avec succès."
            ];
        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    /**
     * Function to select all cycles.
     * @return array
     */
    public function selectAllCycles(): array
    {
        $db = $this->Database();
        $sql = "SELECT * FROM cycles";
        $query = $db->query(query: $sql);
        return $query->fetchAll();
    }

    /**
     * Function to select cycle by id.
     * @return array
     */
    public function selectCycleById($cycle_id): mixed
    {
        $db = $this->Database();
        $sql = "SELECT * FROM cycles WHERE cycle_id = :cycle_id";
        $query = $db->prepare(query: $sql);
        $query->execute(params: ['cycle_id' => $cycle_id]);
        return $query->fetch();
    }

    ######################################## Courses ########################################

    // Ajouter un cours
    public function addCourse($data)
    {
        try {
            $db = $this->Database();
            $sql = "INSERT INTO courses (course_name) VALUES (:course_name)";
            $query = $db->prepare($sql);
            $query->execute([
                'course_name' => $data['course_name'] ?? ''
            ]);
            return ["success" => true, "message" => "Matière ajoutée avec succès !"];
        } catch (Exception $e) {
            $msg = $e->getMessage();
            if (strpos($msg, 'Duplicate entry') !== false) {
                if (strpos($msg, 'course_name') !== false) {
                    $msg = "Cette matière avait déjà été ajoutée.";
                } else {
                    $msg = "Un champ unique a déjà été utilisé.";
                }
            }
            return ["success" => false, "message" => $msg];
        }
    }

    // Modifier un cours
    public function updateCourse($data)
    {
        try {
            $db = $this->Database();
            $sql = "UPDATE courses SET course_name = :course_name WHERE course_id = :course_id";
            $query = $db->prepare($sql);
            $query->execute([
                'course_name' => $data['course_name'],
                'course_id' => $data['course_id']
            ]);
            return ["success" => true, "message" => "Matière modifiée avec succès !"];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    // Supprimer un cours
    public function deleteCourse($course_id)
    {
        try {
            $db = $this->Database();
            $sql = "DELETE FROM courses WHERE course_id = :course_id";
            $query = $db->prepare($sql);
            $query->execute(['course_id' => $course_id]);
            return ["success" => true, "message" => "Matière supprimée avec succès."];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    // Lister tous les cours
    public function selectAllCourses(): array
    {
        $db = $this->Database();
        $sql = "SELECT * FROM courses";
        $query = $db->query($sql);
        return $query->fetchAll();
    }

    // Sélectionner un cours par ID
    public function selectCourseById($course_id): mixed
    {
        $db = $this->Database();
        $sql = "SELECT * FROM courses WHERE course_id = :course_id";
        $query = $db->prepare($sql);
        $query->execute(['course_id' => $course_id]);
        return $query->fetch();
    }

    ######################################## Roles ########################################

    // Ajouter un role
    public function addRole($data)
    {
        try {
            $db = $this->Database();
            $sql = "INSERT INTO roles (role_name) VALUES (:role_name)";
            $query = $db->prepare($sql);
            $query->execute([
                'role_name' => $data['role_name'] ?? ''
            ]);
            return ["success" => true, "message" => "Role ajouté avec succès !"];
        } catch (Exception $e) {
            $msg = $e->getMessage();
            if (strpos($msg, 'Duplicate entry') !== false) {
                if (strpos($msg, 'role_name') !== false) {
                    $msg = "Ce role avait déjà été ajouté.";
                } else {
                    $msg = "Un champ unique a déjà été utilisé.";
                }
            }
            return ["success" => false, "message" => $msg];
        }
    }

    // Modifier un role
    public function updateRole($data)
    {
        try {
            $db = $this->Database();
            $sql = "UPDATE roles SET role_name = :role_name WHERE role_id = :role_id";
            $query = $db->prepare($sql);
            $query->execute([
                'role_name' => $data['role_name'],
                'role_id' => $data['role_id']
            ]);
            return ["success" => true, "message" => "Role modifié avec succès !"];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    // Supprimer un role
    public function deleteRole($role_id)
    {
        try {
            $db = $this->Database();
            $sql = "DELETE FROM roles WHERE role_id = :role_id";
            $query = $db->prepare($sql);
            $query->execute(['role_id' => $role_id]);
            return ["success" => true, "message" => "Role supprimé avec succès."];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    // Lister tous les roles
    public function selectAllRoles(): array
    {
        $db = $this->Database();
        $sql = "SELECT * FROM roles 
            WHERE role_name != 'Super admin'";
        $query = $db->query($sql);
        return $query->fetchAll();
    }

    // Sélectionner un role par ID
    public function selectRoleById($role_id): mixed
    {
        $db = $this->Database();
        $sql = "SELECT * FROM roles WHERE role_id = :role_id";
        $query = $db->prepare($sql);
        $query->execute(['role_id' => $role_id]);
        return $query->fetch();
    }

    // Sélectionner un role par ID
    public function selectRoleByName($role_name): mixed
    {
        $db = $this->Database();
        $sql = "SELECT role_id FROM roles WHERE role_name = :role_name";
        $query = $db->prepare($sql);
        $query->execute(['role_name' => $role_name]);
        return $query->fetch();
    }
    
    ######################################## Access ########################################

    // Ajouter un droit
    public function addAccess($data)
    {
        try {
            $db = $this->Database();
            $sql1 = "INSERT INTO access (access_name, access_section, access_date_add) VALUES (:access_name, :access_section, :access_date_add)";
            $query1 = $db->prepare($sql1);
            $query1->execute([
                'access_name' => $data['access_name'] ?? '',
                'access_section' => $data['access_section'] ?? '',
                'access_date_add' => date('Y-m-d')
            ]);

            $sql2 = "SELECT access_id FROM access ORDER BY access_id DESC LIMIT 1";
            $query2 = $db->query($sql2);
            $result = $query2->fetch();
            $access_id = $result['access_id'];

            $sql3 = "INSERT INTO roles_access(access_id, role_id) VALUES ($access_id, :role_id)";
            $query3 = $db->prepare($sql3);
            $query3->execute(['role_id' => $data['role_id'] ?? '']);

            return [
                "success" => true, 
                "message" => "Droit ajouté avec succès !"
            ];
        } catch (Exception $e) {
            $msg = $e->getMessage();
            if (strpos($msg, 'Duplicate entry') !== false) {
                if (strpos($msg, 'access_name') !== false) {
                    $msg = "Ce droit avait déjà été ajouté.";
                } else {
                    $msg = "Un champ unique a déjà été utilisé.";
                }
            }
            return [
                "success" => false, 
                "message" => $msg
            ];
        }
    }

    // Modifier un droit
    public function updateAccess($data)
    {
        try {
            $db = $this->Database();

            // Mettre à jour la table access
            $sql1 = "UPDATE access SET access_name = :access_name, access_section = :access_section WHERE access_id = :access_id";
            $query1 = $db->prepare($sql1);
            $query1->execute([
                'access_name' => $data['access_name'],
                'access_section' => $data['access_section'],
                'access_id' => $data['access_id']
            ]);

            // Déterminer role_access_id : si fourni, on l'utilise, sinon on le cherche ou on le crée
            $roleAccessId = $data['role_access_id'] ?? null;
            $roleId = $data['role_id'] ?? null;
            $accessId = $data['access_id'] ?? null;

            if (!$roleAccessId) {
                // chercher un roles_access existant pour (access_id, role_id)
                $stmt = $db->prepare("SELECT role_access_id FROM roles_access WHERE access_id = :access_id AND role_id = :role_id LIMIT 1");
                $stmt->execute(['access_id' => $accessId, 'role_id' => $roleId]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row && isset($row['role_access_id'])) {
                    $roleAccessId = $row['role_access_id'];
                } else {
                    // créer l'association si elle n'existe pas
                    $stmtIns = $db->prepare("INSERT INTO roles_access (access_id, role_id) VALUES (:access_id, :role_id)");
                    $stmtIns->execute(['access_id' => $accessId, 'role_id' => $roleId]);
                    $roleAccessId = $db->lastInsertId();
                }
            }

            // Mettre à jour roles_access
            $sql2 = "UPDATE roles_access SET access_id = :access_id, role_id = :role_id WHERE role_access_id = :role_access_id";
            $query2 = $db->prepare($sql2);
            $query2->execute([
                'access_id' => $accessId,
                'role_id' => $roleId,
                'role_access_id' => $roleAccessId
            ]);

            return [
                "success" => true, 
                "message" => "Droit modifié avec succès !"
            ];
        } catch (Exception $e) {
            return [
                "success" => false, 
                "message" => $e->getMessage()
            ];
        }
    }

    // Supprimer un droit
    public function deleteAccess($access_id)
    {
        try {
            $db = $this->Database();
            $sql = "DELETE FROM access WHERE access_id = :access_id";
            $query = $db->prepare($sql);
            $query->execute(['access_id' => $access_id]);
            return [
                "success" => true, 
                "message" => "Droit supprimé avec succès."
            ];
        } catch (Exception $e) {
            return [
                "success" => false, 
                "message" => $e->getMessage()
            ];
        }
    }

    // Lister tous les droits
    public function selectAllAccess(): array
    {
        $db = $this->Database();
        $sql = "SELECT * FROM access, roles, roles_access 
                WHERE roles_access.access_id = access.access_id 
                AND roles_access.role_id = roles.role_id
                AND roles.role_name != 'Super admin'";
        $query = $db->query($sql);
        return $query->fetchAll();
    }

    // Sélectionner un droit par ID
    public function selectAccessById($access_id): mixed
    {
        $db = $this->Database();
        $sql = "SELECT * FROM access, roles, roles_access 
                WHERE roles_access.access_id = access.access_id 
                AND roles_access.role_id = roles.role_id
                AND access.access_id = :access_id";
        $query = $db->prepare($sql);
        $query->execute(['access_id' => $access_id]);
        return $query->fetch();
    }

    ######################################## Levels ########################################

    public function addLevel($data)
    {
        try {
            $db = $this->Database();
            $sql = "INSERT INTO levels (level_name) VALUES (:level_name)";
            $query = $db->prepare($sql);
            $query->execute(['level_name' => $data['level_name'] ?? '']);
            return ["success" => true, "message" => "Classe ajoutée avec succès !"];
        } catch (Exception $e) {
            $msg = $e->getMessage();
            if (strpos($msg, 'Duplicate entry') !== false) {
                if (strpos($msg, 'level_name') !== false) {
                    $msg = "Cette classe avait déjà été ajoutée.";
                } else {
                    $msg = "Un champ unique a déjà été utilisé.";
                }
            }
            return ["success" => false, "message" => $msg];
        }
    }

    public function updateLevel($data)
    {
        try {
            $db = $this->Database();
            $sql = "UPDATE levels SET level_name = :level_name WHERE level_id = :level_id";
            $query = $db->prepare($sql);
            $query->execute([
                'level_name' => $data['level_name'],
                'level_id' => $data['level_id']
            ]);
            return ["success" => true, "message" => "Classe modifiée avec succès !"];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function deleteLevel($level_id)
    {
        try {
            $db = $this->Database();
            $sql = "DELETE FROM levels WHERE level_id = :level_id";
            $query = $db->prepare($sql);
            $query->execute(['level_id' => $level_id]);
            return ["success" => true, "message" => "Classe supprimée avec succès."];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function selectAllLevels(): array
    {
        $db = $this->Database();
        $sql = "SELECT * FROM levels";
        $query = $db->query($sql);
        return $query->fetchAll();
    }

    public function selectLevelById($level_id): mixed
    {
        $db = $this->Database();
        $sql = "SELECT * FROM levels WHERE level_id = :level_id";
        $query = $db->prepare($sql);
        $query->execute(['level_id' => $level_id]);
        return $query->fetch();
    }

    ######################################## Rooms ########################################

    public function addRoom($data)
    {
        try {
            $db = $this->Database();
            $sql = "INSERT INTO rooms (room_name) VALUES (:room_name)";
            $query = $db->prepare($sql);
            $query->execute(['room_name' => $data['room_name'] ?? '']);
            return ["success" => true, "message" => "Salle ajoutée avec succès !"];
        } catch (Exception $e) {
            $msg = $e->getMessage();
            if (strpos($msg, 'Duplicate entry') !== false) {
                if (strpos($msg, 'room_name') !== false) {
                    $msg = "Cette salle avait déjà été ajoutée.";
                } else {
                    $msg = "Un champ unique a déjà été utilisé.";
                }
            }
            return ["success" => false, "message" => $msg];
        }
    }

    public function updateRoom($data)
    {
        try {
            $db = $this->Database();
            $sql = "UPDATE rooms SET room_name = :room_name WHERE room_id = :room_id";
            $query = $db->prepare($sql);
            $query->execute([
                'room_name' => $data['room_name'],
                'room_id' => $data['room_id']
            ]);
            return ["success" => true, "message" => "Salle modifiée avec succès !"];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function deleteRoom($room_id)
    {
        try {
            $db = $this->Database();
            $sql = "DELETE FROM rooms WHERE room_id = :room_id";
            $query = $db->prepare($sql);
            $query->execute(['room_id' => $room_id]);
            return ["success" => true, "message" => "Salle supprimée avec succès."];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function selectAllRooms(): array
    {
        $db = $this->Database();
        $sql = "SELECT * FROM rooms";
        $query = $db->query($sql);
        return $query->fetchAll();
    }

    public function selectRoomById($room_id): mixed
    {
        $db = $this->Database();
        $sql = "SELECT * FROM rooms WHERE room_id = :room_id";
        $query = $db->prepare($sql);
        $query->execute(['room_id' => $room_id]);
        return $query->fetch();
    }

    ######################################## Series ########################################

    public function addSerie($data)
    {
        try {
            $db = $this->Database();
            $sql = "INSERT INTO series (serie_name) VALUES (:serie_name)";
            $query = $db->prepare($sql);
            $query->execute(['serie_name' => $data['serie_name'] ?? '']);
            return ["success" => true, "message" => "Série ajoutée avec succès !"];
        } catch (Exception $e) {
            $msg = $e->getMessage();
            if (strpos($msg, 'Duplicate entry') !== false) {
                if (strpos($msg, 'serie_name') !== false) {
                    $msg = "Cette série avait déjà été ajoutée.";
                } else {
                    $msg = "Un champ unique a déjà été utilisé.";
                }
            }
            return ["success" => false, "message" => $msg];
        }
    }

    public function updateSerie($data)
    {
        try {
            $db = $this->Database();
            $sql = "UPDATE series SET serie_name = :serie_name WHERE serie_id = :serie_id";
            $query = $db->prepare($sql);
            $query->execute([
                'serie_name' => $data['serie_name'],
                'serie_id' => $data['serie_id']
            ]);
            return ["success" => true, "message" => "Série modifiée avec succès !"];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function deleteSerie($serie_id)
    {
        try {
            $db = $this->Database();
            $sql = "DELETE FROM series WHERE serie_id = :serie_id";
            $query = $db->prepare($sql);
            $query->execute(['serie_id' => $serie_id]);
            return ["success" => true, "message" => "Série supprimée avec succès."];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function selectAllSeries(): array
    {
        $db = $this->Database();
        $sql = "SELECT * FROM series";
        $query = $db->query($sql);
        return $query->fetchAll();
    }

    public function selectSerieById($serie_id): mixed
    {
        $db = $this->Database();
        $sql = "SELECT * FROM series WHERE serie_id = :serie_id";
        $query = $db->prepare($sql);
        $query->execute(['serie_id' => $serie_id]);
        return $query->fetch();
    }

    ######################################## Schoolings ########################################

    public function addSchooling($data)
    {
        try {
            $db = $this->Database();
            $sql = "INSERT INTO schoolings (schooling_name) VALUES (:schooling_name)";
            $query = $db->prepare($sql);
            $query->execute(['schooling_name' => $data['schooling_name'] ?? '']);
            return ["success" => true, "message" => "Scolarité ajoutée avec succès !"];
        } catch (Exception $e) {
            $msg = $e->getMessage();
            if (strpos($msg, 'Duplicate entry') !== false) {
                if (strpos($msg, 'schooling_name') !== false) {
                    $msg = "Cette scolarité avait déjà été ajoutée.";
                } else {
                    $msg = "Un champ unique a déjà été utilisé.";
                }
            }
            return ["success" => false, "message" => $msg];
        }
    }

    public function updateSchooling($data)
    {
        try {
            $db = $this->Database();
            $sql = "UPDATE schoolings SET schooling_name = :schooling_name WHERE schooling_id = :schooling_id";
            $query = $db->prepare($sql);
            $query->execute([
                'schooling_name' => $data['schooling_name'],
                'schooling_id' => $data['schooling_id']
            ]);
            return ["success" => true, "message" => "Scolarité modifiée avec succès !"];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function deleteSchooling($schooling_id)
    {
        try {
            $db = $this->Database();
            $sql = "DELETE FROM schoolings WHERE schooling_id = :schooling_id";
            $query = $db->prepare($sql);
            $query->execute(['schooling_id' => $schooling_id]);
            return ["success" => true, "message" => "Scolarité supprimée avec succès."];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function selectAllSchoolings(): array
    {
        $db = $this->Database();
        $sql = "SELECT * FROM schoolings";
        $query = $db->query($sql);
        return $query->fetchAll();
    }

    public function selectSchoolingById($schooling_id): mixed
    {
        $db = $this->Database();
        $sql = "SELECT * FROM schoolings WHERE schooling_id = :schooling_id";
        $query = $db->prepare($sql);
        $query->execute(['schooling_id' => $schooling_id]);
        return $query->fetch();
    }

    ######################################## Fees ########################################

    public function addFee($data)
    {
        try {
            $db = $this->Database();

            // Par défaut, tranches = 0 (néant)
            $tranche1 = $tranche2 = $tranche3 = 0;

            // Vérifier si c'est Contribution
            $stmt = $db->prepare("SELECT schooling_name FROM schoolings WHERE schooling_id = ?");
            $stmt->execute([$data['schooling_id']]);
            $schoolingName = $stmt->fetchColumn();

            if (strtolower($schoolingName) === 'contribution') {
                $tranche1 = !empty($data['tranche1']) ? $data['tranche1'] : 0;
                $tranche2 = !empty($data['tranche2']) ? $data['tranche2'] : 0;
                $tranche3 = !empty($data['tranche3']) ? $data['tranche3'] : 0;
            }

            $sql = "INSERT INTO fees (
                    level_id, 
                    schooling_id, 
                    fee_amount, 
                    tranche1, 
                    tranche2, 
                    tranche3
                )
                VALUES (
                    :level_id, 
                    :schooling_id, 
                    :fee_amount, 
                    :tranche1, 
                    :tranche2, 
                    :tranche3
                )";
            $query = $db->prepare($sql);
            $query->execute([
                'level_id' => $data['level_id'],
                'schooling_id' => $data['schooling_id'],
                'fee_amount' => $data['fee_amount'],
                'tranche1' => $tranche1,
                'tranche2' => $tranche2,
                'tranche3' => $tranche3
            ]);

            return ["success" => true, "message" => "Frais ajouté avec succès !"];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function updateFee($data)
    {
        try {
            $db = $this->Database();

            // Par défaut, tranches = 0 (néant)
            $tranche1 = $tranche2 = $tranche3 = 0;

            // Vérifier si c'est Contribution
            $stmt = $db->prepare("SELECT schooling_name FROM schoolings WHERE schooling_id = ?");
            $stmt->execute([$data['schooling_id']]);
            $schoolingName = $stmt->fetchColumn();

            if (strtolower($schoolingName) === 'contribution') {
                $tranche1 = !empty($data['tranche1']) ? $data['tranche1'] : 0;
                $tranche2 = !empty($data['tranche2']) ? $data['tranche2'] : 0;
                $tranche3 = !empty($data['tranche3']) ? $data['tranche3'] : 0;
            }

            $sql = "UPDATE fees 
                    SET level_id = :level_id, schooling_id = :schooling_id, fee_amount = :fee_amount,
                        tranche1 = :tranche1, tranche2 = :tranche2, tranche3 = :tranche3
                    WHERE fee_id = :fee_id";
            $query = $db->prepare($sql);
            $query->execute([
                'level_id' => $data['level_id'],
                'schooling_id' => $data['schooling_id'],
                'fee_amount' => $data['fee_amount'],
                'tranche1' => $tranche1,
                'tranche2' => $tranche2,
                'tranche3' => $tranche3,
                'fee_id' => $data['fee_id']
            ]);

            return ["success" => true, "message" => "Frais modifié avec succès !"];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }


    public function deleteFee($fee_id)
    {
        try {
            $db = $this->Database();
            $sql = "DELETE FROM fees WHERE fee_id = :fee_id";
            $query = $db->prepare($sql);
            $query->execute(['fee_id' => $fee_id]);
            return ["success" => true, "message" => "Frais supprimé avec succès."];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function selectAllFees(): array
    {
        $db = $this->Database();
        $sql = "SELECT * FROM fees, schoolings, levels 
                WHERE fees.schooling_id = schoolings.schooling_id
                AND fees.level_id = levels.level_id";
        $query = $db->query($sql);
        return $query->fetchAll();
    }

    public function selectFeeById($fee_id): mixed
    {
        $db = $this->Database();
        $sql = "SELECT * FROM fees WHERE fee_id = :fee_id";
        $query = $db->prepare($sql);
        $query->execute(['fee_id' => $fee_id]);
        return $query->fetch();
    }
}