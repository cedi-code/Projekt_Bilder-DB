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
    public function addGallerie( $bname,$bezeichnung, $gid) {

        $query = "INSERT INTO $this->tableName ( bname,  bezeichnung,gid) VALUES (?,?,?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);

        $statement->bind_param("ssi",$bname,$bezeichnung,$gid);

        if(!$statement->execute()) {
            throw new Exception($statement->error);
        }

        $statement->close();
    }

}