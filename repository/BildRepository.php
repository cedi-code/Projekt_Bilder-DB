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
        $query = "SELECT * FROM $this->tableName WHERE gid = ? AND bname = ?";
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param("is", $gid, $bname);

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }
        $rows = $result->num_rows;
        $statement->close();
        return $rows;

    }
    function upload($name,$uid,$gallerieName,$bname) {
        $File = $_FILES[$name];

        $FileName = $_FILES[$name]['name'];
        $FileTmpName = $_FILES[$name]['tmp_name'];
        $FileSize = $_FILES[$name]['size'];
        $FileError = $_FILES[$name]['error'];
        $FileType = $_FILES[$name]['type'];


        $FileExt = explode('.', $FileName);
        $FileActualExt = strtolower(end($FileExt));

        if($FileActualExt === 'png' || $FileActualExt === 'jpg') {
            if($FileError === 0) {
                if($FileSize < 4000000) {
                    if($name == 'galleriePic') {
                        $FileUper = strtoupper($FileActualExt);
                        $fileName = 'profile.'.$FileUper;
                    }else {
                        // Hier wird der Name gemacht der Datei (timestamp)
                        $FileUper = strtoupper($FileActualExt);
                        $date = new DateTime();
                        $timestamp = $date->getTimestamp();
                        // $fileName =  $timestamp . '.' . $FileUper;
                        $fileName = $bname . '.' . $FileUper;

                    }

                    $fileDestination = $uid.'/'.$gallerieName.'/'.$fileName;
                    move_uploaded_file($FileTmpName, $fileDestination);
                    return $fileName;
                }else {
                    echo "<pre>";

                    echo 'size';
                    var_dump($_FILES[$name]);die;
                }
            }else {
                echo "<pre>";
                echo 'err';
                var_dump($_FILES[$name]);die;
            }
        }else {
            echo "<pre>";

            echo 'type';
            var_dump($_FILES[$name]);die;
        }

    }

}