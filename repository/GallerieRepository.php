<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 03.05.2018
 * Time: 10:26
 */
require_once '../lib/Repository.php';
class GallerieRepository extends Repository
{
    protected $tableName = 'galerie';
    protected $tableId = 'id';
    protected $order = 'gname,  path, beschreibung, uid, isPublic';

    public function addGallerie( $name,$beschreibung, $uid,$path,$isPublic) {

        $query = "INSERT INTO $this->tableName ( gname,  path, beschreibung, uid, isPublic) VALUES (?,?,?,?,?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);

        $statement->bind_param("sssii",$name,$path,$beschreibung, $uid,$isPublic);

        if(!$statement->execute()) {
            throw new Exception($statement->error);
        }

        $statement->close();
    }

    public function updateGallerie($id, $newName, $newBeschreibung , $isPublic) {
        $query = "UPDATE $this->tableName SET gname= ?, beschreibung= ?, isPublic= ? WHERE id = " .$id;
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param("ssi",$newName,$newBeschreibung,$isPublic);
        if(!$statement->execute()) {
            throw new Exception($statement->error);
        }

        $statement->close();
    }




public function checkName($name, $uid) {
        $query = "SELECT * FROM $this->tableName WHERE uid = ? AND gname = ? ";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param("is", $uid, $name);
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


    public function getGalleries($uid) {
        $query = "SELECT * FROM $this->tableName WHERE uid = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param("i", $uid);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }


        $rows = [];
        while($row = $result->fetch_object()){
            array_push($rows,$row);
        }

        $statement->close();
        return $rows;
    }

    public function getPublicGalleries() {
        $query = "SELECT * FROM $this->tableName WHERE isPublic = 1";
        $statement = ConnectionHandler::getConnection()->prepare($query);

        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }
        $rows = [];
        while($row = $result->fetch_object()){
            array_push($rows,$row);
        }

        $statement->close();
        return $rows;

    }


}