<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 26.04.2018
 * Time: 11:07
 */
require_once '../repository/GallerieRepository.php';
require_once '../repository/BildRepository.php';
class GalerieController
{
    public function add($id) {
        $wrong = null;
        $daten = null;
        $gName = null;
        $public = 0;
        $gDescripttion = null;
        $gallerieRepository = new GallerieRepository();
        if(isset($_SESSION['uid'])) {

            if(isset($id)) {
                $daten = $gallerieRepository->readById($id);
                $gName = $daten->gname;
                $gDescripttion = $daten->beschreibung;
                $public = $daten->isPublic;
            }
            if(isset($_POST['sendGalerie'])) {
                $gName = $_POST['name'];
                $gDescripttion = $_POST['description'];
                $public = $_POST['isPublic'];

                if(!empty($public)) {
                    $public = 1;
                }else {
                    $public = 0;
                }
                if(empty($gName) || empty($gDescripttion)) {
                    $wrong = "Felder sind leer!";
                }else {

                    if($gallerieRepository->checkName($gName, $_SESSION['uid']) < 1 || $daten->gname == $gName ){
                        $path = $this->makePath($_SESSION['uid'],$gName);

                        // $gallerieRepository->upload('galleriePic',$_SESSION['uid'],$gName);
                        if(isset($id)) {
                            $gallerieRepository->updateGallerie($id,$gName,$gDescripttion,$public);

                            header("Location: " . $GLOBALS['appurl'] ."/galerie/show/" . $id);
                        }else {

                            $gallerieRepository->addGallerie($gName,$gDescripttion, $_SESSION['uid'],$path,$public);
                            header("Location: " . $GLOBALS['appurl'] ."/benutzer");
                        }




                    } else {
                        $wrong = "Galerie Name ist bereits vorhanden!";
                    }

                }
            }


            $view = new View('galerie_edit');
            if(isset($id)) {
                $view->title = 'Galerie Bearbeiten';
                $view->heading = 'Galerie Bearbeiten';
                $view->gid = $id;
            }else {
                $view->title = 'Galerie Hinzufügen';
                $view->heading = 'Galerie Hinzufügen';
            }

            $view->name = $gName;
            $view->descripttion = $gDescripttion;
            $view->public = $public;
            $view->err = $wrong;
            $view->display();
        }else {
            header("Location: " . $GLOBALS['appurl'] ."/login");
        }

    }
    public function show($id) {

        $gallerieRepository = new GallerieRepository();
        $bildRepository = new BildRepository();

        $galerrieInfo = $gallerieRepository->readById($id);
        if($galerrieInfo->isPublic || $_SESSION['uid'] == $galerrieInfo->uid) {
            $bildInfo = $bildRepository->getBilder($id);
            $view = new View('galerie_show');
            $view->title = 'Galerie ' .$galerrieInfo->gname;
            $view->heading = $galerrieInfo->gname;
            $view->beschreibung = $galerrieInfo->beschreibung;
            $view->path = $galerrieInfo->path;
            $view->bilder = $bildInfo;
            $view->id = $galerrieInfo->id;
            $view->uid = $galerrieInfo->uid;
            $view->public = $galerrieInfo->isPublic;
            $view->display();
        }else {
            header("Location: " . $GLOBALS['appurl']);
        }

    }
    public function delete($id) {
        $gal = new GallerieRepository();
        $gal->deleteById($id);
        header("Location: " . $GLOBALS['appurl'] ."/benutzer");
    }
    function makePath($uid, $name) {
        $path = $uid . "/" . $name ;

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        return $path;
    }


}