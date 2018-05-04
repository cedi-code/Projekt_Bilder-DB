<?php

require_once '../lib/Repository.php';
/**
 *
 */
class BenutzerRepository extends Repository
{

  public function updateUser( $nickname,$email,$passwort) {
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
