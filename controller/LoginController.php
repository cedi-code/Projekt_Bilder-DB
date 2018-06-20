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
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
            $pw = htmlspecialchars($_POST['passwort'], ENT_QUOTES, 'UTF-8');
            if(empty($email) || empty($pw)){
                $erros = $this->errMsg("empty");
            }else {
                if($loginRepository->checkMail($email)){
                    $uid = $loginRepository->checkPW($email,$pw);
                    if($uid !== null) {
                        $_SESSION['uid'] = $uid;
                        $_SESSION['uname'] = $loginRepository->readById($uid)->nickname;
                        header("Location: ". $GLOBALS['appurl'] . " /benutzer");
                    }else {
                        $erros = $this->errMsg("vpasswort"); // mail gibt es schon oder ist ungültig
                    }
                }else {
                    $erros = $this->errMsg("vmail"); // mail gibt es schon oder ist ungültig
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
            $nickname = htmlspecialchars($_POST['nickname'], ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
            $passwort = htmlspecialchars($_POST['passwort'], ENT_QUOTES, 'UTF-8');
            $v_passwort = htmlspecialchars($_POST['v_passwort'], ENT_QUOTES, 'UTF-8');
            if(empty($nickname) || empty($email) || empty($passwort) || empty($v_passwort)) {
                $errorMsg = $this->errMsg("empty");
            }else {
                if(strlen($nickname) < 50 || strlen($nickname) > 3) {
                    if(!$loginRepository->checkMail($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        if(preg_match($passwortPattern, $passwort) === 1){
                            if($passwort == $v_passwort) {
                                $loginRepository->addUser($nickname,$email,$passwort);
                                $_SESSION["succMsg"] = $this->errMsg("succ");
                                header("Location: ". $GLOBALS['appurl'] ."/login");
                            }else {
                                $errorMsg = $this->errMsg("vpasswort"); // nicht gleiches Passwort
                            }
                        }else {
                            $errorMsg = $this->errMsg("bpasswort"); // schlechtes Passwort mind. 1Kleinbuchstaben, 1Grossbuchstaben, 1Zahl, 1Sonderzeichen und 5lang sein
                        }

                    }else {
                        $errorMsg = $this->errMsg("mailInvalid"); // mail gibt es schon oder ist ungültig
                    }

                }else {
                    $errorMsg = $this->errMsg("usrname"); // username ungültig (zu lang oder zu kurz)
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
?>