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
            if(isset($_POST['sendBild'])) {
                $bname = $_POST['name'];
                $bezeichnung = $_POST['bez'];
                $gid = $_POST['gid'];
                $bildData = new BildRepository();
                if(!empty($bname) || !empty($bezeichnung) || !empty($gid)) {
                    //if($bildData->checkBildName($gid,$bname) < 1) {
                        // TODO kontrollieren ob die Gallerie Exiziert!
                        $galData = new GallerieRepository();
                        $gName = $galData->readById($gid)->gname;
                        $bname = $bildData->upload('pic',$_SESSION['uid'],$gName,$bname);
                        $bildData->addBild( $bname,$bezeichnung, $gid);
                        header("Location: " . $GLOBALS['appurl'] . "/galerie/show/" . $gid);
                    /*}else {
                        $wrong = "Dieser Bild name exsistiert schon in dieser Gallerie";
                    }*/
                }else {
                    $wrong = "Alle Felder müssen ausgefüllt werden!";
                }
                // pic -> for file


            }
            if(!isset($id)) {
                $id = 0;
            }
            $view = new View('bild_edit');
            $view->title = 'Bild Hinzufügen';
            $view->heading = 'Bild Hinzufügen';
            $view->gid = $id;
            $view->err = $wrong;
            $view->display();
        }else {
            header("Location: " . $GLOBALS['appurl'] ."/login");
        }

    }
    public function upload() {

    }
}