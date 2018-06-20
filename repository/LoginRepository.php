<?php
require_once '../lib/Repository.php';
/**
 * Datenbankschnittstelle für die Benutzer
 */
  class LoginRepository extends Repository
  {
      protected $tableName = 'user';
      protected $tableId = 'id';
      protected $order = 'Nachname, Vorname';

      public function checkMail($email)
      {
          $query = "SELECT * FROM $this->tableName WHERE email = ?";
          $statement = ConnectionHandler::getConnection()->prepare($query);
          $statement->bind_param("s", $email);
          $statement->execute();

          $result = $statement->get_result();
          if (!$result) {
              throw new Exception($statement->error);
          }


          // zählen wie viele rows man hat!!!!!!!!!!!¨¨
          $rows = $result->num_rows;
          $statement->close();
          return $rows;
      }
      public function checkPW($email, $pw) {
          $query = "SELECT * FROM $this->tableName WHERE email = ?";
          $statement = ConnectionHandler::getConnection()->prepare($query);
          $statement->bind_param("s", $email);
          $statement->execute();

          $result = $statement->get_result();
          if (!$result) {
              throw new Exception($statement->error);
          }
          $rows = $result->fetch_object();

          if(password_verify($pw,$rows->passwd)) {
              $statement->close();
              return $rows->id;
          }else {

              $statement->close();
              return null;
          }

      }

      public function addUser( $nickname,$email,$passwort) {
          $passwd = password_hash($passwort,  PASSWORD_DEFAULT);
          $query = "INSERT INTO $this->tableName ( email, passwd, nickname) VALUES (?,?,?)";
          $statement = ConnectionHandler::getConnection()->prepare($query);

          $statement->bind_param("sss",$email,$passwd,$nickname);

          if(!$statement->execute()) {
            throw new Exception($statement->error);
          }

          $statement->close();
      }
  }
?>
