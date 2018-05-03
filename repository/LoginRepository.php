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
      public function errMsg($type) {
          switch ($type) {
              case "empty":
                  return "<p class='errMsg'>Some Textboxes are empty!</p>";
              case "usrname":
                  return "<p class='errMsg'>username is invalid (min 3char)</p>";
              case "mailInvalid":
                  return "<p class='errMsg'>Mail already exists or is invalid</p>";
              case "vmail":
                  return "<p class='errMsg'>Email doesn't match!</p>";
              case "bpasswort":
                  return "<p class='errMsg'>Password needs mind 1lowercase, 1uppercase, 1number and 1additional character!</p>";
              case "vpasswort":
                  return "<p class='errMsg'>Password doesn't match!</p>";
              case "succ":
                  return "<p class='succMsg'>Registration successful</p>";
              default:
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