<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    class ScolaritiesController
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

        public function selectStudentsListScolarities($year_id)
        {
            try {
                $db = $this->Database();

                $sql = "
                    SELECT 
                        s.student_id,
                        s.student_matricule,
                        u.user_lastname AS student_lastname,
                        u.user_firstname AS student_firstname,
                        -- si une réinscription existe pour l'année, utiliser son libellé, sinon celui de l'inscription
                        COALESCE(rsub.year_name, y.year_name) AS year_name,
                        COALESCE(rsub.level_name, l.level_name) AS level_name,
                        COALESCE(rsub.serie_name, se.serie_name) AS serie_name,
                        COALESCE(rsub.room_name, ro.room_name) AS room_name,
                        pu.user_phone AS parent_phone,
                        f.fee_amount AS total_fee,
                        COALESCE(paid.total_paid, 0) AS amount_paid,
                        (f.fee_amount - COALESCE(paid.total_paid, 0)) AS amount_due,
                        paid.last_payment_date,
                        CASE 
                            WHEN (f.fee_amount - COALESCE(paid.total_paid, 0)) = 0 THEN 'Soldé'
                            WHEN COALESCE(paid.total_paid, 0) > 0 THEN 'En cours...'
                            ELSE 'Non payé'
                        END AS payment_status
                    FROM students s
                    INNER JOIN users u ON s.user_id = u.user_id
                    INNER JOIN years y ON s.year_id = y.year_id
                    INNER JOIN parents pa ON s.parent_id = pa.parent_id
                    INNER JOIN users pu ON pa.user_id = pu.user_id
                    INNER JOIN levels l ON s.level_id = l.level_id
                    INNER JOIN series se ON s.serie_id = se.serie_id
                    INNER JOIN rooms ro ON s.room_id = ro.room_id
                    /* fees : on prend le tarif lié au niveau (attention si fees contient plusieurs schooling_id) */
                    LEFT JOIN fees f ON f.level_id = s.level_id
                    /* total payé par élève (regroupé par student_id & schooling_id) */
                    LEFT JOIN (
                        SELECT student_id, schooling_id, SUM(payement_amount) AS total_paid, MAX(paiement_date) AS last_payment_date
                        FROM payements
                        GROUP BY student_id, schooling_id
                    ) AS paid ON paid.student_id = s.student_id AND paid.schooling_id = f.schooling_id
                    /* sous-requête réinscription pour l'année demandée (alias rsub pour éviter collision) */
                    LEFT JOIN (
                        SELECT r.student_id,
                            r.level_id,
                            r.serie_id,
                            r.room_id,
                            r.year_id,
                            l.level_name AS level_name,
                            se.serie_name AS serie_name,
                            ro.room_name AS room_name,
                            y.year_name AS year_name
                        FROM reinscriptions r
                        INNER JOIN levels l ON r.level_id = l.level_id
                        INNER JOIN series se ON r.serie_id = se.serie_id
                        INNER JOIN rooms ro ON r.room_id = ro.room_id
                        INNER JOIN years y ON r.year_id = y.year_id
                        WHERE r.year_id = :year_id
                    ) AS rsub ON rsub.student_id = s.student_id
                    WHERE s.year_id = :year_id OR rsub.student_id IS NOT NULL
                    ORDER BY s.student_id
                ";

                $stmt = $db->prepare($sql);
                $stmt->execute(['year_id' => $year_id]);
                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $students;

            } catch (Exception $e) {
                return ["success" => false, "message" => $e->getMessage()];
            }
        }


        public function getStudentPaymentDetails($id)
        {
            try {
                $pdo = $this->Database();

                $sql = "
                    SELECT 
                        s.student_id,
                        s.student_matricule,
                        u.user_lastname AS student_lastname,
                        u.user_firstname AS student_firstname,
                        COALESCE(rsub.year_name, y.year_name) AS year_name,
                        COALESCE(rsub.level_name, l.level_name) AS level_name,
                        COALESCE(rsub.serie_name, se.serie_name) AS serie_name,
                        COALESCE(rsub.room_name, ro.room_name) AS room_name,
                        up.user_phone AS parent_phone,
                        f.fee_amount,
                        f.tranche1,
                        f.tranche2,
                        f.tranche3,
                        IFNULL(SUM(p.payement_amount), 0) AS amount_paid,
                        (f.fee_amount - IFNULL(SUM(p.payement_amount), 0)) AS amount_due,
                        MAX(p.paiement_date) AS last_payment_date,
                        CASE 
                            WHEN IFNULL(SUM(p.payement_amount), 0) = 0 THEN 'Non payé'
                            WHEN IFNULL(SUM(p.payement_amount), 0) < f.fee_amount THEN 'En cours...'
                            ELSE 'Soldé'
                        END AS payment_status
                    FROM students s
                    INNER JOIN users u ON s.user_id = u.user_id
                    INNER JOIN parents pa ON s.parent_id = pa.parent_id
                    INNER JOIN users up ON pa.user_id = up.user_id
                    INNER JOIN years y ON s.year_id = y.year_id
                    INNER JOIN levels l ON s.level_id = l.level_id
                    INNER JOIN series se ON s.serie_id = se.serie_id
                    INNER JOIN rooms ro ON s.room_id = ro.room_id
                    LEFT JOIN fees f ON f.level_id = s.level_id
                    LEFT JOIN payements p ON p.student_id = s.student_id
                    /* réinscription pour récupérer la dernière année si elle existe */
                    LEFT JOIN (
                        SELECT 
                            r.student_id,
                            y.year_name,
                            l.level_name,
                            se.serie_name,
                            ro.room_name
                        FROM reinscriptions r
                        INNER JOIN years y ON r.year_id = y.year_id
                        INNER JOIN levels l ON r.level_id = l.level_id
                        INNER JOIN series se ON r.serie_id = se.serie_id
                        INNER JOIN rooms ro ON r.room_id = ro.room_id
                        /* On prend la dernière réinscription si plusieurs */
                        WHERE r.year_id = (SELECT MAX(year_id) FROM reinscriptions WHERE student_id = r.student_id)
                    ) AS rsub ON rsub.student_id = s.student_id
                    WHERE s.student_id = :id
                    GROUP BY 
                        s.student_id, 
                        s.student_matricule, 
                        u.user_lastname, 
                        u.user_firstname,
                        year_name,
                        level_name,
                        serie_name,
                        room_name,
                        up.user_phone,
                        f.fee_amount,
                        f.tranche1,
                        f.tranche2,
                        f.tranche3
                ";

                $stmt = $pdo->prepare($sql);
                $stmt->execute(['id' => $id]);
                $student = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($student) {
                    return ["success" => true, "message" => $student];
                } else {
                    return ["success" => true, "message" => "Aucun élève trouvé avec cet identifiant."];
                }

            } catch (Exception $e) {
                return ["success" => false, "message" => $e->getMessage()];
            }
        }

        public function addPayment($data)
        {
            try {
                $db = $this->Database();

                // Calcul du statut du paiement
                $sqlFee = "SELECT f.fee_amount 
                        FROM fees f
                        INNER JOIN students s ON f.level_id = s.level_id
                        INNER JOIN schoolings sc ON f.schooling_id = sc.schooling_id
                        WHERE s.student_id = :student_id
                        LIMIT 1";
                $stmtFee = $db->prepare($sqlFee);
                $stmtFee->execute(['student_id' => $data['student_id']]);
                $fee = $stmtFee->fetch(PDO::FETCH_ASSOC);
                $totalFee = $fee ? floatval($fee['fee_amount']) : 0;

                // Total déjà payé
                $sqlPaid = "SELECT IFNULL(SUM(payement_amount), 0) AS total_paid 
                            FROM payements 
                            WHERE student_id = :student_id";
                $stmtPaid = $db->prepare($sqlPaid);
                $stmtPaid->execute(['student_id' => $data['student_id']]);
                $paid = $stmtPaid->fetch(PDO::FETCH_ASSOC);
                $totalPaid = floatval($paid['total_paid']);

                $newTotal = $totalPaid + floatval($data['payement_amount']);

                // Déterminer le statut
                $statut = "En cours...";
                if ($newTotal >= $totalFee) {
                    $statut = "Terminé";
                } elseif ($newTotal == 0) {
                    $statut = "Non payé";
                }

                // Insertion du paiement
                $sql = "INSERT INTO payements 
                            (schooling_id, student_id, paiement_date, payement_amount, payement_mode, payement_statut)
                        VALUES 
                            (:schooling_id, :student_id, CURDATE(), :payement_amount, :payement_mode, :payement_statut)";
                $query = $db->prepare($sql);
                $query->execute([
                    'schooling_id' => $data['schooling_id'],
                    'student_id' => $data['student_id'],
                    'payement_amount' => $data['payement_amount'],
                    'payement_mode' => $data['payement_mode'],
                    'payement_statut' => $statut
                ]);

                return ["success" => true, "message" => "Paiement enregistré avec succès !"];
            } catch (Exception $e) {
                return ["success" => false, "message" => $e->getMessage()];
            }
        }

    }
?>