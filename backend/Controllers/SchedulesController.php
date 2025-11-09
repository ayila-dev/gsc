<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class SchedulesController
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

    public function getTeacherIdByName($user_firstname, $user_lastname)
    {
        $db = $this->Database();

        $sql = "SELECT t.teacher_id
                FROM teachers t
                INNER JOIN users u ON t.user_id = u.user_id
                WHERE u.user_firstname = :user_firstname AND u.user_lastname = :user_lastname
                LIMIT 1";

        $query = $db->prepare($sql);
        $query->execute([
            'user_firstname' => $user_firstname,
            'user_lastname' => $user_lastname
        ]);

        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['teacher_id'] ?? null;
    }

    /* ============================
    AJOUTER UN EMPLOI DU TEMPS
    ============================ */
    public function addSchedule($data)
    {
        $db = $this->Database();

        try {
            // Vérifier que tous les champs nécessaires existent
            $required = [
                'teacher_id',
                'place_id', 
                'level_id', 
                'serie_id', 
                'course_id', 
                'room_id', 
                'schedule_day', 
                'schedule_start_time', 
                'schedule_end_time'
            ];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return [
                        'success' => false, 
                        'message' => "Champ manquant : $field"
                    ];
                }
            }

            $sql = "INSERT INTO schedules (
                        teacher_id, 
                        year_id, 
                        place_id, 
                        cycle_id, 
                        level_id, 
                        serie_id, 
                        course_id, 
                        schedule_day, 
                        schedule_start_time, 
                        schedule_end_time,
                        room_id
                    ) VALUES (
                        :teacher_id, 
                        :year_id, 
                        :place_id, 
                        :cycle_id, 
                        :level_id, 
                        :serie_id, 
                        :course_id, 
                        :schedule_day, 
                        :schedule_start_time, 
                        :schedule_end_time,
                        :room_id
                    )";
            $query = $db->prepare($sql);
            $query->execute([
                ':teacher_id' => $data['teacher_id'],
                ':year_id' => $_SESSION['year_id'],
                ':place_id' => $data['place_id'],
                ':cycle_id' => $_SESSION['cycle_id'],
                ':level_id' => $data['level_id'],
                ':serie_id' => $data['serie_id'],
                ':course_id' => $data['course_id'],
                ':schedule_day' => $data['schedule_day'],
                ':schedule_start_time' => $data['schedule_start_time'],
                ':schedule_end_time' => $data['schedule_end_time'],
                ':room_id' => $data['room_id']
            ]);

            return ['success' => true, 'message' => 'Emploi du temps ajouté avec succès'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


    /* ============================
    MODIFIER UN EMPLOI DU TEMPS
    ============================ */
    public function updateSchedule($data)
    {
        try {
            $db = $this->Database();

            $sql = "UPDATE schedules SET 
                        teacher_id = :teacher_id,
                        place_id = :place_id,
                        level_id = :level_id,
                        serie_id = :serie_id,
                        course_id = :course_id,
                        schedule_day = :schedule_day,
                        schedule_start_time = :schedule_start_time,
                        schedule_end_time = :schedule_end_time,
                        room_id = :room_id
                    WHERE schedule_id = :schedule_id";
            $query = $db->prepare($sql);
            $query->execute([
                'schedule_id' => $data['schedule_id'],
                'teacher_id' => $data['teacher_id'],
                'place_id' => $data['place_id'],
                'level_id' => $data['level_id'],
                'serie_id' => $data['serie_id'],
                'course_id' => $data['course_id'],
                'schedule_day' => $data['schedule_day'],
                'schedule_start_time' => $data['schedule_start_time'],
                'schedule_end_time' => $data['schedule_end_time'],
                'room_id' => $data['room_id']
            ]);

            return ["success" => true, "message" => "Emploi du temps modifié avec succès !"];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    /* ===========================
    SUPPRIMER UN EMPLOI DU TEMPS
    ============================ */
    public function deleteSchedule($schedule_id)
    {
        try {
            $db = $this->Database();
            $sql = "DELETE FROM schedules WHERE schedule_id = :schedule_id";
            $query = $db->prepare($sql);
            $query->execute(['schedule_id' => $schedule_id]);
            return ["success" => true, "message" => "Emploi du temps supprimé avec succès."];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    /* ================================
    SÉLECTIONNER TOUS LES EMPLOIS DU TEMPS
    ================================= */
    public function selectAllSchedules()
    {
        $db = $this->Database();

        $sql = "
            SELECT 
                s.schedule_id, 
                s.schedule_day, 
                s.schedule_start_time, 
                s.schedule_end_time, 
                s.schedule_date_add,
                u.user_firstname, 
                u.user_lastname,
                c.course_name, 
                l.level_name, 
                cy.cycle_name, 
                se.serie_name, 
                p.place_name, 
                y.year_name, 
                r.room_name
            FROM schedules s
            JOIN teachers t ON s.teacher_id = t.teacher_id
            JOIN users u ON t.user_id = u.user_id
            JOIN courses c ON s.course_id = c.course_id
            JOIN levels l ON s.level_id = l.level_id
            JOIN cycles cy ON s.cycle_id = cy.cycle_id
            JOIN series se ON s.serie_id = se.serie_id
            JOIN places p ON s.place_id = p.place_id
            JOIN years y ON s.year_id = y.year_id
            JOIN rooms r ON s.room_id = r.room_id
            WHERE y.year_id = ". $_SESSION['year_id'];
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ======================================
    SÉLECTIONNER UN EMPLOI DU TEMPS PAR ID
    ======================================= */
    public function selectScheduleById($schedule_id)
    {
        $db = $this->Database();

        $sql = "SELECT 
                    s.*, 
                    c.course_name, 
                    l.level_name, 
                    cy.cycle_name, 
                    se.serie_name,
                    p.place_name,
                    y.year_name,
                    CONCAT(u.user_firstname, ' ', u.user_lastname) AS teacher_name
                FROM schedules s
                INNER JOIN teachers t ON s.teacher_id = t.teacher_id
                INNER JOIN users u ON t.user_id = u.user_id
                INNER JOIN courses c ON s.course_id = c.course_id
                INNER JOIN levels l ON s.level_id = l.level_id
                INNER JOIN cycles cy ON s.cycle_id = cy.cycle_id
                INNER JOIN series se ON s.serie_id = se.serie_id
                INNER JOIN places p ON s.place_id = p.place_id
                INNER JOIN years y ON s.year_id = y.year_id
                WHERE s.schedule_id = :schedule_id";

        $query = $db->prepare($sql);
        $query->execute([
            'schedule_id' => $schedule_id
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function generateTimetablePDF($data)
    {
        
        try {
            $db = $this->Database();
            $sql = "
                SELECT 
                    s.schedule_id,
                    s.schedule_day,
                    s.schedule_start_time,
                    s.schedule_end_time,
                    s.schedule_date_add,
                    c.course_name,
                    l.level_name,
                    cy.cycle_name,
                    se.serie_name,
                    p.place_name,
                    y.year_name,
                    r.room_name,
                    CONCAT(u.user_firstname, ' ', UPPER(u.user_lastname)) AS teacher_name
                FROM schedules s
                INNER JOIN teachers t ON s.teacher_id = t.teacher_id
                INNER JOIN users u ON t.user_id = u.user_id
                INNER JOIN courses c ON s.course_id = c.course_id
                INNER JOIN levels l ON s.level_id = l.level_id
                INNER JOIN cycles cy ON s.cycle_id = cy.cycle_id
                INNER JOIN series se ON s.serie_id = se.serie_id
                INNER JOIN rooms r ON s.room_id = r.room_id
                INNER JOIN years y ON s.year_id = y.year_id
                INNER JOIN places p ON s.place_id = p.place_id
                WHERE s.level_id = :level_id
                AND s.serie_id = :serie_id
                AND s.room_id = :room_id
                ORDER BY FIELD(s.schedule_day, 'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'), s.schedule_start_time
            ";

            $query = $db->prepare($sql);
            $query->execute([
                'level_id' => $data['level_id'],
                'serie_id' => $data['serie_id'],
                'room_id' => $data['room_id']
            ]);

            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            $_SESSION['level_id'] = $data['level_id'] ?? null;
            $_SESSION['serie_id'] = $data['serie_id'] ?? null;
            $_SESSION['room_id'] = $data['room_id'] ?? null;

            $_SESSION['level_name'] = $data['level_name'] ?? ($results[0]['level_name'] ?? null);
            $_SESSION['serie_name'] = $data['serie_name'] ?? ($results[0]['serie_name'] ?? null);
            $_SESSION['room_name'] = $data['room_name'] ?? ($results[0]['room_name'] ?? null);
            $_SESSION['year_name'] = $results[0]['year_name'] ?? null;

            return [
                'success' => true, 
                'params' => [
                    'level_id' => $_SESSION['level_id'],
                    'serie_id' => $_SESSION['serie_id'],
                    'room_id' => $_SESSION['room_id'],
                    'level_name' => $_SESSION['level_name'],
                    'serie_name' => $_SESSION['serie_name'],
                    'room_name' => $_SESSION['room_name'],
                    'year_name' => $_SESSION['year_name']
                ],
                'data' => $results, 
                'message' => 'Emploi du temps généré avec succès.'
            ];
        }
        catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
?>
