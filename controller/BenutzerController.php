<?php
require_once '../repository/BenutzerRepository.php';
require_once '../repository/LoginRepository.php';
require_once '../repository/GallerieRepository.php';
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
                $gallerieRepository = new GallerieRepository();
                $view = new View('user_index');
                $view->title = 'Bilder-DB';
                $view->heading = $_SESSION['uname'];
                $view->galleries = $gallerieRepository->getGalleries($_SESSION['uid']);
                $view->display();


        }else {
            header("Location: " . $GLOBALS['appurl'] ."/login");
        }


    }
    public function showAdmin() {
        if(isset($_SESSION['admin'])) {
            $ben = new BenutzerRepository();

            $view = new View('admin_index');
            $view->title = 'Admin';
            $view->heading = $_SESSION['uname'];
            $view->benutzer = $ben->readAll();
            $view->display();
        }else {
            header("Location: " . $GLOBALS['appurl'] ."/login");
        }


    }
    public function gotoUser($uid) {
        $_SESSION['uid'] = $uid;
        $this->index();


    }
    public function doEdit()
    {


        $benutzerRepository = new BenutzerRepository();
        $benutzerData = $benutzerRepository->readById($_SESSION['uid']);
        $loginRepository = new LoginRepository();
        $errorMsg = null;
        $email = $benutzerData->email;
        $nickname = $benutzerData->nickname;
        $piss =  '/Projekt_Bilder-DB/public'; // $GLOBALS['appurl'];
        if(isset($_POST['sendE'])) {
            $nickname = htmlspecialchars($_POST['nickname'], ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
            if(empty($nickname) || empty($email)) {
                $errorMsg = $this->errMsg("empty");
                 //printr("dfdasfssfas");

            }else {
                if(strlen($nickname) < 50 || strlen($nickname) > 3) {
                    if((!$loginRepository->checkMail($email) > 0 || $email == $benutzerData->email)&& filter_var($email, FILTER_VALIDATE_EMAIL)) {

                                $benutzerRepository->updateUser($nickname,$email);
                                $_SESSION["succMsg"] = $this->errMsg("succ");
                                $_SESSION['uname'] = $nickname;
                                
                                header("Location: ". $GLOBALS['appurl'] ."/benutzer");



                    }else {
                        $errorMsg = $this->errMsg("mailInvalid"); // mail gibt es schon oder ist ungültig
                    }

                }else {
                    $errorMsg = $this->errMsg("usrname"); // username ungültig (zu lang oder zu kurz)
                }
            }



        }



      $view = new View('user_edit');
      $view->title = 'Bilder-DB';
      $view->heading = 'Benutzerdaten bearbeiten';
      $view->error = $errorMsg;
      $view->mail = $email;
      $view->usr = $nickname;
      $view->display();
    }
    public function deleteUser() {
        $gal = new GallerieRepository();
        foreach ($gal->getGalleries($_SESSION['uid']) as $g) {
            $delete = $gal->readById($g->id)->path;
            $gal->rrmdir($delete);
            $gal->deleteById($g->id);
        }
        unlink("/". $_SESSION['uid']);
        $ben = new BenutzerRepository();
        $ben->deleteById($_SESSION['uid']);
    }

    public function errMsg($type) {
        switch ($type) {
            case "empty":
                return "<p class='errMsg'>Some Textboxes are empty!</p>";
            case "usrname":
                return "<p class='errMsg'>username is invalid (min 3char)</p>";
            case "mailInvalid":
                return "<p class='errMsg'>Mail already exists or is invalid</p>";
            case "vmail":
                return "<p class='errMsg'>Email doesn't match!</p>";
            case "bpasswort":
                return "<p class='errMsg'>Password needs mind 1lowercase, 1uppercase, 1number and 1additional character!</p>";
            case "vpasswort":
                return "<p class='errMsg'>Password doesn't match!</p>";
            case "succ":
                return "<p class='succMsg'>Registration successful</p>";
            default:
                return null;

        }

    }
}
