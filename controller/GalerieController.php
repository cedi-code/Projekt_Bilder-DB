<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 26.04.2018
 * Time: 11:07
 */

class GalerieController
{
    public function index() {
        $wrong = null;

        if(isset($_SESSION['uid'])) {
            if(isset($_POST['sendGalerie'])) {
                $gName = $_POST['name'];
                $gDescripttion = $_POST['description'];
                if(empty($gName) || empty($gDescripttion)) {
                    $wrong = "Felder sind leer!";
                }else {

                    header("Location: " . $GLOBALS['appurl'] ."/benutzer");
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

}