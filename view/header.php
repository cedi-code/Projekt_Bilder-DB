<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?=$GLOBALS['appurl']?>/css/bootstrap.min.css">
    <!-- Custom styles for this template -->
    <link href="<?=$GLOBALS['appurl']?>/css/style.css" rel="stylesheet">
	<script src="<?=$GLOBALS['appurl']?>/js/jscript.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <title><?= $title ?></title>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header text-center">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" >
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar">
            </span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?=$GLOBALS['appurl']?>">Bilder-DB</a>
        </div>
        <div id="MyNavbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
			<!-- fix schf -->

              <?php if(isset($_SESSION['uid'])) {
                  echo "<li><a href=\"" . $GLOBALS['appurl'] ."/benutzer\">" .$_SESSION['uname'] . "</a></li>";
                  echo "<li><a href=\"" . $GLOBALS['appurl'] ."/login/logout\">Logout</a></li>";
              }else {
                  echo "<li><a href=\"" . $GLOBALS['appurl'] ."/login\">Login</a></li>
                        <li><a href=\"" . $GLOBALS['appurl'] . "/login/registration\">Registration</a></li>";
              } ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
    <?php echo "<div class='center-nav'>"; ?>
    <h1><?= $heading ?></h1>
