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


        $benutzerRepository = new BenutzerRepository();
        $loginRepository = new LoginRepository();
        $errorMsg = null;
        $email = null;
        $nickname = null;
        $piss =  '/Projekt_Bilder-DB/public'; // $GLOBALS['appurl'];
        if(isset($_POST['sendE'])) {
            $nickname = $_POST['nickname'];
            $email = $_POST['email'];
            if(empty($nickname) || empty($email)) {
                $errorMsg = $loginRepository->errMsg("empty");
                 //printr("dfdasfssfas");

            }else {
                if(strlen($nickname) < 50 || strlen($nickname) > 3) {
                    if(!$loginRepository->checkMail($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {

                                $benutzerRepository->updateUser($nickname,$email);
                                $_SESSION["succMsg"] = $loginRepository->errMsg("succ");
                                $_SESSION['uname'] = $nickname;
                                
                                header("Location: ". $GLOBALS['appurl'] ."/benutzer");



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
