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

    public function addGallerie( $name,$beschreibung, $uid,$path) {

        $query = "INSERT INTO $this->tableName ( gname,  path, beschreibung, uid) VALUES (?,?,?,?)";
        $statement = ConnectionHandler::getConnection()->prepare($query);

        $statement->bind_param("sssi",$name,$path,$beschreibung, $uid);

        if(!$statement->execute()) {
            throw new Exception($statement->error);
        }

        $statement->close();
    }
    // TODO add in DATABASE!
    public function addImage($name,$dscr,$inputname,$uid,$gallerieName) {


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


    function upload($name,$uid,$gallerieName) {
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
                if($FileSize < 1000000) {
                    if($name == 'galleriePic') {
                        $FileUper = strtoupper($FileActualExt);
                        $fileName = 'profile.'.$FileUper;
                    }else {
                        // Hier wird der Name gemacht der Datei (timestamp)
                        $FileUper = strtoupper($FileActualExt);
                        $date = new DateTime();
                        $timestamp = $date->getTimestamp();
                        $fileName =  $timestamp . '.' . $FileUper;
                    }

                    $fileDestination = $uid.'/'.$gallerieName.'/'.$fileName;
                    move_uploaded_file($FileTmpName, $fileDestination);
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