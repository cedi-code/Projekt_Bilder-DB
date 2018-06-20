<?php

require_once '../lib/Repository.php';
/**
 *
 */

class BenutzerRepository extends Repository
{
  protected $tableName = 'user';
    protected $tableId = 'id';

  public function updateUser( $nickname,$email) {

      $query = "UPDATE $this->tableName SET email= ?,nickname= ? WHERE id = " .$_SESSION['uid'];
      $statement = ConnectionHandler::getConnection()->prepare($query);
      $statement->bind_param("ss",$email,$nickname);

      if(!$statement->execute()) {
        throw new Exception($statement->error);
      }

      $statement->close();
  }
  //UPDATE `user` SET `email`="mili.s@iclouid.com",`passwd`="gibbiX12345$",`nickname`="max" WHERE id=1;














}
 ?>
