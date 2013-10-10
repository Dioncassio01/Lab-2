<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once 'HTMLPage.php';
require_once 'login.php';

session_start();

/**
 * @var userName (HARD CODED) In a real (not hard coded)is need a database
 * @var password (HARD CODED) same as in user name!
 *
 */
$userName = 'Admin';
$password = 'Password';
$Autologin = 'Checked';
$user = "";
$pass = "";
$check = "unchecked";

$pageView = new \view\HTMLPage();
$login = new \model\login();

if (isset($_GET["logout"])) {
	$login -> doLogout();
} else {
	if (isset($_SESSION[\model\login::LoggedIn]) && $_SESSION[\model\login::LoggedIn] == TRUE) {
		echo $login -> doLogin();

	} else {
		//rätt användaruppgifter
		if ($login -> controller()) {
						
			if($login -> getuserName() == $userName && $login -> getPassword() == $password && $login->checkAutologin()){
				echo $login-> doCheckbox();
			 	
			}elseif ($login -> getuserName() == $userName && $login -> getPassword() == $password) {
				echo $login -> doLogin();
				//TODO:fix it
			}elseif ($login ->getuserName()==""){
				echo $login->doCheckusername();
			}elseif ($login ->getPassword()== ""){
				echo $login->doCheckPassword();
			}
			else {
				//if (!$login -> checkUserName($login -> getuserName()) && !$login -> checkPassword($login -> getPassword()))
					echo $login -> doCorrectLogging();
				//fel använddaruppgifter
			}
		} else {
			//TODO::Look up why don't show the first page
			//hämta inloggningsformulär
			echo $login -> getform();
		}
	}
}

//echo '<hr /><h2>SESSION</h2><pre>';
//var_dump($_SESSION);
//echo '</pre>';

//echo '<h2>$_POST</h2>';
//echo '<pre>';
//var_dump($_POST);
//echo '</pre>';

//echo '<h2>$_GET</h2>';
//echo '<pre>';
//var_dump($_GET);
//echo '</pre>';
?>
