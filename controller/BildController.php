<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 18.05.2018
 * Time: 08:39
 */
require_once '../repository/GallerieRepository.php';
require_once '../repository/BildRepository.php';
class BildController
{

    public function index() {

    }
    public function edit($id) {
        if(isset($_SESSION['uid'])) {
            $wrong = null;
            $edit = false;
            $bbname = null;
            $bbezeichnung = null;
            if(isset($_POST['sendBild'])) {
                $bname = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
                $bezeichnung = htmlspecialchars($_POST['bez'], ENT_QUOTES, 'UTF-8');
                $gid = htmlspecialchars($_POST['gid'], ENT_QUOTES, 'UTF-8');
                $bildData = new BildRepository();
                if(!empty($bname) && !empty($bezeichnung) && !empty($gid) && (!empty($_FILES['pic']) || isset($_GET['bid']))) {
                    if($bildData->checkBildName($gid,$bname) < 1) {
                        // TODO kontrollieren ob die Gallerie Exiziert!
                        if(isset($_GET['bid'])) {
                            $bildData->updateImage($_GET['bid'],$bname,$bezeichnung);
                        }else {
                            $galData = new GallerieRepository();
                            $gName = $galData->readById($gid)->gname;
                            $bname = $this->upload('pic',$_SESSION['uid'],$gName,$bname);
                            $bildData->addBild( $bname,$bezeichnung, $gid);
                        }

                        header("Location: " . $GLOBALS['appurl'] . "/galerie/show/" . $gid);
                    }else {
                        $wrong = "Dieser Bild name exsistiert schon in dieser Gallerie";
                    }
                }else {
                    $wrong = "Alle Felder müssen ausgefüllt werden!";
                }
                // pic -> for file


            }
            if(!isset($id)) {
                $id = 0;
            }
            if(isset($_GET['bid'])) {
                $edit = true;
                $bildData2 = new BildRepository();
                $bildo = $bildData2->readById($_GET['bid']);
                $bbname = $bildo->bname;
                $bbezeichnung = $bildo->bezeichnung;
            }
            $view = new View('bild_edit');
            if($edit) {
                $view->title = 'Bild Bearbeiten';
                $view->heading = 'Bild Bearbeiten';
            }else {
                $view->title = 'Bild Hinzufügen';
                $view->heading = 'Bild Hinzufügen';
            }

            $view->gid = $id;
            $view->bname = $bbname;
            $view->bezeichnung = $bbezeichnung;
            $view->edit = $edit;
            $view->err = $wrong;
            $view->display();
        }else {
            header("Location: " . $GLOBALS['appurl'] ."/login");
        }

    }
    public function delete($id) {
        $bildData = new BildRepository();
        $toDelete = $bildData->readById($id);
        $galid = $toDelete->gid;
        $name = $toDelete->bname;
        $galData = new GallerieRepository();
        $pathPublic =$galData->readById($galid)->path;
        unlink($pathPublic . "/" . $name);
        unlink($pathPublic . "/Thumbnail-" . $name);
        $bildData->deleteById($id);
        header("Location: " . $GLOBALS['appurl'] . "/galerie/show/".$galid . "");
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
                    $fileDestinationPath = $uid.'/'.$gallerieName.'/';
                    if(move_uploaded_file($FileTmpName, $fileDestination)) {
                        $this->genThumb($fileDestination,$fileDestinationPath,$fileName,$FileActualExt);
                    }
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

    function genThumb($fileDestination,$path,$fileName,$FileActualExt) {
        list($width, $height) = getimagesize($fileDestination);
        $r = $width / $height;
        $factor = $width / $height;
        $newheight = 150;
        $newwidth = 150 * $factor;
        if($FileActualExt == "png"){
            $src = imagecreatefrompng($fileDestination);
            $dst = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

            imagepng($dst, $path . "Thumbnail-" . $fileName);
        }else{
            $src = imagecreatefromjpeg($fileDestination);
            $dst = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

            imagejpeg($dst, $path . "Thumbnail-" . $fileName);
        }
    }
}