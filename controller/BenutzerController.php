<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 26.04.2018
 * Time: 10:40
 */

class BenutzerController
{
    public function index() {
        if(isset($_SESSION['uid'])) {
            $view = new View('user_index');
            $view->title = 'Bilder-DB';
            $view->heading = $_SESSION['uname'];
            $view->display();
        }else {
            header("Location: " . $GLOBALS['appurl'] ."/login");
        }


    }
    public function edit() {
        if(isset($_SESSION['uid'])) {
            $view = new View('user_edit');
            $view->title = 'Bilder-DB';
            $view->heading = $_SESSION['uname'];
            $view->display();
        }else {
            header("Location: " . $GLOBALS['appurl'] ."/login");
        }


    }
}
