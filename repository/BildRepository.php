<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 17.05.2018
 * Time: 11:17
 */
require_once '../lib/Repository.php';
class BildRepository extends Repository
{
    protected $tableName = 'bild';
    protected $tableId = 'id';
    protected $order = 'bname,  bezeichnung, gid';



    public function getBilder($gid) {
        $query = "SELECT * FROM $this->tableName WHERE gid = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param("i", $gid);
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

    public function addBild( $bname,$bezeichnung, $gid) {

        $query = "INSERT INTO $this->tableName ( bname,  bezeichnung,gid) VALUES (?,?,?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);

        $statement->bind_param("ssi",$bname,$bezeichnung,$gid);

        if(!$statement->execute()) {
            throw new Exception($statement->error);
        }

        $statement->close();
    }

    public function checkBildName($gid,$bname) {
        $name = $bname . ".JPG";
        $query = "SELECT * FROM $this->tableName WHERE gid = ? AND bname = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param("is", $gid, $name);
        if(!$statement->execute()) {
            throw new Exception($statement->error);
        }
        $result = $statement->get_result();
        $rows = $result->num_rows;
        $statement->close();
        return $rows;

    }
    public function updateImage($id, $newName, $newBeschreibung ) {
        $query = "UPDATE $this->tableName SET bname= ?, bezeichnung= ? WHERE id = " .$id;
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param("ss",$newName,$newBeschreibung);
        if(!$statement->execute()) {
            throw new Exception($statement->error);
        }

        $statement->close();
    }

    public function getRandomBildName($gallid) {
        $query = "SELECT bname FROM $this->tableName WHERE gid = $gallid
                          ORDER BY RAND()
                          LIMIT 1";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }
        if($result->num_rows > 0) {
            return "Thumbnail-" .$result->fetch_object()->bname;
        }else {
            return "../../default.svg";
        }


    }

}