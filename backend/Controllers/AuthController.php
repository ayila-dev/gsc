<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

class AuthController
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

     public function checkUserByEmail($data)
     {
          try {
               $db = $this->Database();
               $query1 = $db->prepare("SELECT * FROM users WHERE user_email = :user_email");
               $query1->execute(['user_email' => $data['user_email']]);
               $result = $query1->fetch();
               
               if ($result && password_verify($data['user_password'], $result['user_password'])) 
               {
                    if (session_status() === PHP_SESSION_NONE) {
                         session_start();
                    }
                    
                    // Infos de base
                    $_SESSION['user_id'] = $result['user_id'];
                    $_SESSION['user_firstname'] = $result['user_firstname'];
                    $_SESSION['user_lastname'] = $result['user_lastname'];
                    $_SESSION['user_email'] = $result['user_email'];

                    return [
                         "success" => true, 
                         "message" => "Vous êtes connecté avec succès !"
                    ];
               } else {
                    return [
                         "success" => false, 
                         "message" => "Adresse e-mail ou mot de passe incorect"
                    ];
               }
          } catch (Exception $e) {
               $msg = $e->getMessage();
               return [
                    "success" => false, 
                    "message" => $msg
               ];
          }
     }

     public function changePasswordAtFirstConnection($data)
     {
          if (session_status() === PHP_SESSION_NONE) {
               session_start();
          }

          try {
               $db = $this->Database();

               // Utiliser l'email de la session ou du formulaire
               $user_email = $_SESSION['user_email'] ?? ($data['user_email'] ?? null);
               if (!$user_email) {
                    return [
                         "success" => false,
                         "message" => "Email de l'utilisateur introuvable en session."
                    ];
               }

               $query1 = $db->prepare("SELECT * FROM users WHERE user_email = :user_email");
               $query1->execute(['user_email' => $user_email]);
               $result = $query1->fetch(PDO::FETCH_ASSOC);

               if (!$result) {
                    return [
                         "success" => false,
                         "message" => "Utilisateur introuvable."
                    ];
               }

               if ((int)$result['user_first_connection'] === 0) {
                    // Met à jour le statut
                    $query2 = $db->prepare("UPDATE users 
                         SET user_first_connection = :user_first_connection 
                         WHERE user_id = :user_id");
                    $query2->execute([
                         'user_first_connection' => 1,
                         'user_id' => $result['user_id']
                    ]);

                    // Hash du nouveau mot de passe
                    $new_password_hash = password_hash($data['user_password_change'], PASSWORD_DEFAULT);

                    // Mise à jour du mot de passe
                    $query3 = $db->prepare("UPDATE users 
                         SET user_password = :user_password 
                         WHERE user_id = :user_id");
                    $query3->execute([
                         'user_password' => $new_password_hash,
                         'user_id' => $result['user_id']
                    ]);

                    return [
                         "success" => true,
                         "message" => "Mot de passe changé avec succès !"
                    ];
               } else {
                    return [
                         "success" => false,
                         "message" => "Cet utilisateur a déjà changé son mot de passe."
                    ];
               }
          } catch (Exception $e) {
               return [
                    "success" => false,
                    "message" => $e->getMessage()
               ];
          }
     }


     public function checkUserRoleById($user_id)
     {
          $db = $this->Database();
          $query = $db->prepare("SELECT role_name 
               FROM users 
               JOIN roles 
               ON users.role_id = roles.role_id 
               WHERE users.user_id = ?;"
          );
          $query->execute([$user_id]);
          $result = $query->fetch();
          return $result;
     }

     public function checkUserAccessById($user_id)
     {
          $db = $this->Database();
          $query = $db->prepare("SELECT access_name 
               FROM users 
               JOIN roles_access
               ON users.role_id = roles_access.role_id
               JOIN access
               ON roles_access.access_id = access.access_id
               WHERE users.user_id = ?;"
          );
          $query->execute([$user_id]);
          $result = $query->fetch();
          return $result;
     }

     public function getUserAccessListById($user_id)
     {
          $db = $this->Database();
          $query = $db->prepare("SELECT access.access_name, access.access_section
               FROM users
               JOIN roles_access 
               ON users.role_id = roles_access.role_id
               JOIN access 
               ON roles_access.access_id = access.access_id
               WHERE users.user_id = ?;");
          $query->execute([$user_id]);
          $accessList = $query->fetchAll(PDO::FETCH_ASSOC);
          return $accessList;
     }

     public function checkUserPlaceById($user_id)
     {
          $db = $this->Database();
          $query = $db->prepare("SELECT place_name 
               FROM users 
               JOIN personals
               ON users.user_id = personals.user_id
               JOIN places
               ON personals.place_id = places.place_id
               WHERE users.user_id = ?;"
          );
          $query->execute([$user_id]);
          $result = $query->fetch();
          return $result;
     }

     public function checkSchoolYearById($year_id)
     {
          $db = $this->Database();
          $query = $db->prepare("SELECT year_name FROM years WHERE years.year_id = ?;");
          $query->execute([$year_id]);
          $result = $query->fetch();
          return $result;
     }

     public function checkSchoolCycleById($cycle_id)
     {
          $db = $this->Database();
          $query = $db->prepare("SELECT cycle_name FROM cycles WHERE cycles.cycle_id = ?;");
          $query->execute([$cycle_id]);
          $result = $query->fetch();
          return $result;
     }
    
     public function checkUserFirstConnectionById($user_email)
     {
          $db = $this->Database();
          $query = $db->prepare("SELECT user_first_connection FROM users WHERE users.user_email = ?;");
          $query->execute([$user_email]);
          return $query->fetch();
     }
}
