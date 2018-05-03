<?php
require_once '../repository/LoginRepository.php';
/**
 * Controller für das Login und die Registration, siehe Dokumentation im DefaultController.
 */
  class LoginController
  {
    /**
     * Default-Seite für das Login: Zeigt das Login-Formular an
	 * Dispatcher: /login
     */

    public function index()
    {
        $erros = null;
        $loginRepository = new LoginRepository();

        if(isset($_POST['send'])) {
            $email = $_POST['email'];
            $pw = $_POST['passwort'];
            if(empty($email) || empty($pw)){
                $erros = $loginRepository->errMsg("empty");
            }else {
                if($loginRepository->checkMail($email)){
                    $uid = $loginRepository->checkPW($email,$pw);
                    if($uid !== null) {
                        $_SESSION['uid'] = $uid;
                        $_SESSION['uname'] = $loginRepository->readById($uid)->nickname;
                        header("Location: ". $GLOBALS['appurl'] . " /benutzer");
                    }else {
                        $erros = $loginRepository->errMsg("vpasswort"); // mail gibt es schon oder ist ungültig
                    }
                }else {
                    $erros = $loginRepository->errMsg("vmail"); // mail gibt es schon oder ist ungültig
                }
            }
        }

        $view = new View('login_index');
        $view->title = 'Bilder-DB';
        $view->heading = 'Login';
        $view->err = $erros;
        $view->display();
    }
    /**
     * Zeigt das Registrations-Formular an
	 * Dispatcher: /login/registration
     */
    public function registration()
    {


        $loginRepository = new LoginRepository();
        $passwortPattern = "((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%èüÜÈéöÖÉÄÀäà_\-?!'`^~\]\[£{}+*.°ç&()¢=]).{4,40})";
        $errorMsg = null;
        $email = null;
        $nickname = null;
        $piss =  '/Projekt_Bilder-DB/public'; // $GLOBALS['appurl'];
        if(isset($_POST['sendR'])) {
            $nickname = $_POST['nickname'];
            $email = $_POST['email'];
            $passwort = $_POST['passwort'];
            $v_passwort = $_POST['v_passwort'];
            if(empty($nickname) || empty($email) || empty($passwort) || empty($v_passwort)) {
                $errorMsg = $loginRepository->errMsg("empty");


            }else {
                if(strlen($nickname) < 50 || strlen($nickname) > 3) {
                    if(!$loginRepository->checkMail($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        if(preg_match($passwortPattern, $passwort) === 1){
                            if($passwort == $v_passwort) {
                                $loginRepository->addUser($nickname,$email,$passwort);
                                $_SESSION["succMsg"] = $loginRepository->errMsg("succ");
                                header("Location: ". $GLOBALS['appurl'] ."/login");
                            }else {
                                $errorMsg = $loginRepository->errMsg("vpasswort"); // nicht gleiches Passwort
                            }
                        }else {
                            $errorMsg = $loginRepository->errMsg("bpasswort"); // schlechtes Passwort mind. 1Kleinbuchstaben, 1Grossbuchstaben, 1Zahl, 1Sonderzeichen und 5lang sein
                        }

                    }else {
                        $errorMsg = $loginRepository->errMsg("mailInvalid"); // mail gibt es schon oder ist ungültig
                    }

                }else {
                    $errorMsg = $loginRepository->errMsg("usrname"); // username ungültig (zu lang oder zu kurz)
                }
            }



        }



      $view = new View('login_registration');
      $view->title = 'Bilder-DB';
      $view->heading = 'Registration';
      $view->error = $errorMsg;
      $view->mail = $email;
      $view->usr = $nickname;
      $view->display();
    }

    public function logout() {
        @session_start();
        session_destroy();
        header("Location: " . $GLOBALS['appurl'] ."/");
    }

    public function  checkLogin() {
        $erros = null;
        $loginRepository = new LoginRepository();
        if(isset($_POST['send'])) {
            $email = $_POST['email'];
            $pw = $_POST['passwort'];
            if(empty($email) || empty($pw)){
                $_SESSION['errorM'] = $loginRepository->errMsg("empty");
                header("Location: ". $GLOBALS['appurl'] ."/login");
            }else {
                if($loginRepository->checkMail($email)){
                    if($loginRepository->checkPW($email,$pw)) {
                        echo "Login Zucc";
                    }else {
                        $erros = $loginRepository->errMsg("vpasswort"); // mail gibt es schon oder ist ungültig
                    }
                }else {
                    $erros = $loginRepository->errMsg("vmail"); // mail gibt es schon oder ist ungültig
                }
            }
        }
        $view = new View('login_index');
        $view->title = 'Bilder-DB';
        $view->heading = 'Login';
        $view->display();

    }
    public function checkRegistration() {
        @session_start();
        $loginRepository = new LoginRepository();
        $passwortPattern = "((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%èüÜÈéöÖÉÄÀäà_\-?!'`^~\]\[£{}+*.°ç&()¢=]).{4,40})";
        $piss =  '/Projekt_Bilder-DB/public'; // $GLOBALS['appurl'];
        $email = null;
        $passwort = null;
        if(isset($_POST['sendR'])) {
            $nickname = $_POST['nickname'];
            $email = $_POST['email'];
            $passwort = $_POST['passwort'];
            $v_passwort = $_POST['v_passwort'];

            if(empty($nickname) || empty($email) || empty($passwort) || empty($v_passwort)) {
                $_SESSION['errorM'] = $loginRepository->errMsg("empty");
                header("Location: ". $GLOBALS['appurl'] ."/login/registration");

            }else {
                if(strlen($nickname) < 50 || strlen($nickname) > 3) {
                    if(!$loginRepository->checkMail($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        if(preg_match($passwortPattern, $passwort) === 1){
                            if($passwort == $v_passwort) {
                                $loginRepository->addUser($nickname,$email,$passwort);
                                $_SESSION["succMsg"] = $loginRepository->errMsg("succ");
                                $this->index();
                            }else {
                                $_SESSION['errorM'] = $loginRepository->errMsg("vpasswort"); // nicht gleiches Passwort
                                header("Location: /Projekt_Bilder-DB/public/login/registration");
                            }
                        }else {
                            $_SESSION['errorM'] = $loginRepository->errMsg("bpasswort"); // schlechtes Passwort mind. 1Kleinbuchstaben, 1Grossbuchstaben, 1Zahl, 1Sonderzeichen und 5lang sein
                            header("Location: ". $GLOBALS['appurl'] ."/login/registration");
                        }

                    }else {
                        $_SESSION['errorM'] = $loginRepository->errMsg("mailInvalid"); // mail gibt es schon oder ist ungültig
                        header("Location: ". $GLOBALS['appurl'] ."/login/registration");
                    }

                }else {
                    $_SESSION['errorM'] = $loginRepository->errMsg("usrname"); // username ungültig (zu lang oder zu kurz)
                    header("Location: ". $GLOBALS['appurl'] ."/login/registration");
                }
            }



        }else {
            $_SESSION['errorM'] = $loginRepository->errMsg("empty");
            header("Location: ". $GLOBALS['appurl'] ."/login/registration");
        }

    }
}
?>