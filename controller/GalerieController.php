<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 26.04.2018
 * Time: 11:07
 */
require_once '../repository/GallerieRepository.php';
class GalerieController
{
    public function index() {
        $wrong = null;
        $gallerieRepository = new GallerieRepository();
        if(isset($_SESSION['uid'])) {
            if(isset($_POST['sendGalerie'])) {
                $gName = $_POST['name'];
                $gDescripttion = $_POST['description'];
                if(empty($gName) || empty($gDescripttion)) {
                    $wrong = "Felder sind leer!";
                }else {
                    if($gallerieRepository->checkName($gName, $_SESSION['uid']) < 1){
                        $path = $this->makePath($_SESSION['uid'],$gName);

                        $gallerieRepository->upload('galleriePic',$_SESSION['uid'],$gName);

                        $gallerieRepository->addGallerie($gName,$gDescripttion, $_SESSION['uid'],$path);

                        header("Location: " . $GLOBALS['appurl'] ."/benutzer");

                    } else {
                        $wrong = "Galerie Name ist bereits vorhanden!";
                    }

                }
            }


            $view = new View('galerie_edit');
            $view->title = 'Galerie Hinzufügen';
            $view->heading = 'Galerie Hinzufügen';
            $view->err = $wrong;
            $view->display();
        }else {
            header("Location: " . $GLOBALS['appurl'] ."/login");
        }

    }
    public function show($id) {

        $gallerieRepository = new GallerieRepository();
        $galerrieInfo = $gallerieRepository->readById($id);

        $view = new View('galerie_show');
        $view->title = 'Galerie ' .$galerrieInfo->gname;
        $view->heading = 'Galerie ' .$galerrieInfo->gname;
        $view->beschreibung = $galerrieInfo->beschreibung;
        $view->display();
    }
    function makePath($uid, $name) {
        $path = $uid . "/" . $name ;

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        return $path;
    }


}