<?php
require_once '../repository/BenutzerRepository.php';
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
    public function edit() {
        if(isset($_SESSION['uid'])) {
            if (isset($_POST['sendE'])) {
              // code...
            }
            $view = new View('user_edit');
            $view->title = 'Bilder-DB';
            $view->heading = $_SESSION['uname'];
            $view->display();
        }else {
            header("Location: " . $GLOBALS['appurl'] ."/login");
        }


    }
    public function doEdit()
    {


        $loginRepository = new BenutzerRepository();
        $passwortPattern = "((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%èüÜÈéöÖÉÄÀäà_\-?!'`^~\]\[£{}+*.°ç&()¢=]).{4,40})";
        $errorMsg = null;
        $email = null;
        $nickname = null;
        $piss =  '/Projekt_Bilder-DB/public'; // $GLOBALS['appurl'];
        if(isset($_POST['sendE'])) {
            $nickname = $_POST['nickname'];
            $email = $_POST['email'];
            if(empty($nickname) || empty($email) || empty($passwort) || empty($v_passwort)) {
                //$errorMsg = $BenutzerRepository->errMsg("empty");


            }else {
                if(strlen($nickname) < 50 || strlen($nickname) > 3) {
                    if(!$loginRepository->checkMail($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {

                                $loginRepository->updateUser($nickname,$email);
                                $_SESSION["succMsg"] = $benutzerRepository->errMsg("succ");
                                header("Location: ". $GLOBALS['appurl'] ."/user");


                    }else {
                        $errorMsg = $loginRepository->errMsg("mailInvalid"); // mail gibt es schon oder ist ungültig
                    }

                }else {
                    $errorMsg = $loginRepository->errMsg("usrname"); // username ungültig (zu lang oder zu kurz)
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
}
