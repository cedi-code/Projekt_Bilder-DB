<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 03.05.2018
 * Time: 10:26
 */
require_once '../lib/Repository.php';
class GallerieRepository
{
    protected $tableName = 'galerie';
    protected $tableId = 'id';
    protected $order = 'gname,  path, beschreibung, uid';

    public function addUser( $name,$beschreibung, $uid) {
        $path = $uid . "/" . $name ;

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $query = "INSERT INTO $this->tableName ( gname,  path, beschreibung, uid) VALUES (?,?,?,?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);

        $statement->bind_param("sssi",$name,$path,$beschreibung, $uid);

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


        // zählen wie viele rows man hat!!!!!!!!!!!¨¨
        $rows = $result->fetch_object();
        $statement->close();
        return $rows;
    }

}