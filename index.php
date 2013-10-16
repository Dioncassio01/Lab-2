<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once 'HTMLPage.php';
require_once 'login.php';

session_start();

if (isset($_SESSION["session_test"]) == FALSE) {
	$_SESSION["session_test"] = array();
	$_SESSION["session_test"]["webbläsare"] = $_SERVER["HTTP_USER_AGENT"];
	$_SESSION["session_test"]["ip"] = $_SERVER["REMOTE_ADDR"];
}
if ($_SESSION["session_test"]["webbläsare"] != $_SERVER["HTTP_USER_AGENT"]) {
	echo "sessiontjuv !!!";
	//$_SESSION["session_test"]["felaktig session"]=TRUE;
}
if ($_SESSION["session_test"]["ip"] != $_SERVER["REMOTE_ADDR"]) {
	echo "sessiontjuv ip!!!";
}

var_dump($_COOKIE);

if (isset($_COOKIE["somecookie"])) {
	//är det giltig cooki?
	$cookieEndTime = file_get_contents("endtime.text");
	echo "$cookieEndTime";

	if (time() > $cookieEndTime) {
		echo "cookie is to old";
	} else {
		echo "Cookie is fine";
	}

}
$endtime = time() + 10;
file_put_contents("$enttime.txt", "$endtime");
setcookie("somecookie", "", time() + 10);
//var_dump($_SERVER);

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
	if (isset($_SESSION[\model\login::LoggedIn])) {
		echo $login -> doLogin();

	} else {
		//rätt användaruppgifter
		if ($login -> controller()) {

			if ($login -> getuserName() == $userName && $login -> getPassword() == $password && $login -> checkAutologin()) {
				echo $login -> doCheckbox();
			} elseif ($login -> getuserName() == $userName && $login -> getPassword() == $password) {
				echo $login -> doLogin();
			} elseif ($login -> getuserName() == "") {
				echo $login -> doCheckusername();
			} elseif ($login -> getPassword() == "") {
				echo $login -> doCheckPassword();
			} else {
				//if (!$login -> checkUserName($login -> getuserName()) && !$login -> checkPassword($login -> getPassword()))
				echo $login -> doCorrectLogging();
				//fel använddaruppgifter
			}
		} else {
			//inloggning med cookies
			if (!isset($_SESSION[\model\login::LoggedIn]) && isset($_COOKIE['userNamecookie'])) {
				echo $login -> dosavedCookies();
			} else
				//hämta inloggningsformulär
				echo $login -> doloadPage();
		}
	}
}
