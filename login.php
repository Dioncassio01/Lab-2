<?php

namespace model;
/*
 * @Class login 
 * this 
 * @author Dion Dutra
 */
class login {
	/*
	 * @var this should be a database representation
	 */
	private $correctUserName = 'Admin';
	private $correctPassword = 'Password';
	/*
	 *@var Username is constant to avoid string dependency 
	 */
	const UserName = 'userName';
	/*
	 *@var Password is constant to avoid string dependency 
	 */
	const Password = 'paswword';
	/*
	 *@var LoggedIn is constant to avoid string dependency 
	 */
	const LoggedIn = 'loggedin';
	/*
	 *@var user is constant to avoid string dependency 
	 */
	const user = "";
	/*
	 *@var Autologin is constant to avoid string dependency 
	 */
	const Autologin = 'checked';

	/*
 	* @type string|null 
 	*/
	private $pageView = NULL;

	/*
	 * Instantiate a new login instance  
	 */
	public function __construct() {
		$this -> pageView = new \view\HTMLPage();
	}
	/*
	 * Controlls the input in Post
	 * 
	 * @return boolean
	 */
	public function controller() {
		if (isset($_POST[self::UserName])) {
			return TRUE;
		}
		return FALSE;
	}
	/*
	 * Check if user is correct
	 * 
	 * @param $username
	 * return boolean 
	 */
	public function checkUserName($userName) {
		if ($userName == $this -> correctUserName) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	/*
	 * Check if is correct the correct Password
	 * 
	 * @param $password
	 * return boolean 
	 */
	public function checkPassword($password) {
		if ($password == $this -> correcPassword) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	/*
	 * Check if the user is Autoinloggad
	 * 
	 * return boolean 
	 */
	public function checkAutologin() {
		if (isset($_POST[self::Autologin])) {
			return TRUE;
		}
		return FALSE;
	}
	/*
	 * Download page
	 */
	public function doloadPage() {
		if (!isset($_POST[self::UserName])) {

			$title = "Laboration 2";
			$body = "<h1>Laborationskod dd22ay</h1>
				<h2>Ej Inloggad</h2>
				<form action='?login' method='post'>
				<fieldset>
				<legend>
					Login - Skiv in användarnamn och lösenord
				</legend>
				<label for='" . self::UserName . "'>Användarnamn :</label>
				<input type='text' size='20' name='" . self::UserName . "' id='" . self::UserName . "'/>
				<label for='" . self::Password . "'>Lösenord :</label>
				<input  type='password' size='20' name='" . self::Password . "' id='" . self::Password . "'/>
				<label for='" . self::Autologin . "'> Håll mig inloggad : </label>
				<input type='Checkbox' name='" . self::Autologin . "' id=' " . self::Autologin . "'/>
				<input type='submit' name:'" . self::Autologin . "' value='Logga in'/>
				</fieldset>
				</form>";

			echo $this -> pageView -> getPage($title, $body);
		}
	}
	/*
	 * gets the form 
	 */
	function getform() {
		return "<h1>Laborationskod dd22ay</h1>
			<h2>Ej Inloggad</h2>
			<form action='?login' method='post'>
			<fieldset>
			<legend>
				Login - Skiv in användarnamn och lösenord
			</legend>
			<label for='" . self::UserName . "'>Användarnamn :</label>
			<input 	type='text' size='20' name='" . self::UserName . "' id='" . self::UserName . "'
			value='" . $this -> getuserName() . "'/>
			<label for='" . self::Password . "'>Lösenord :</label>
			<input type='password' size='20' name='" . self::Password . "'
			id='" . self::Password . "'/>
			<label for='" . self::Autologin . "'>Håll mig inloggad : </label>
			<input type='Checkbox' name='" . self::Autologin . "' id=' " . self::Autologin . "' 
			value='" . $this -> getAutologin . "'/>
			<input type='submit' value='Logga in'/>
			</fieldset>
			</form>";
	}
	/*
	 * Shows logged page and gets a message
	 */
	public function doLogin() {
		if ($this -> user == $this -> userName && $this -> pass == $this -> password) {
			$_SESSION[self::LoggedIn] = TRUE;

			$title = "Laboration 2 - Inloggad";
			$body .= "<h1>Laborationskod dd22ay</h1>
					<h2>Admin är Inloggad</h2>
					<p> Inloggning lyckades!</p>
					<a href='?logout'>Logga ut</a>";

			echo $this -> pageView -> getPage($title, $body);
		}
	}
	/*
	 * 
	 */
	public function doCheckusername() {
		if ($this -> user == "") {
			$title = "Laboration 2 - Användanamn saknas!";
			$body = $this -> getform();
			$body .= "<p>Användanamn saknas!</p>";
			echo $this -> pageView -> getPage('Logga in', $body);
		}
	}

	public function doCheckPassword() {
		if ($this -> pass == "") {
			$title = "Laboration 2 - Lösenord saknas";
			$body = $this -> getform();
			$body .= "Lösenord saknas";
			echo $this -> pageView -> getPage($title, $body);
		}
	}

	public function doCorrectLogging() {
		//if ($user == $userName && $pass != $password) {
		$title = "Laboration 2 - Felaktig lösenord";
		$body = $this -> getform();
		$body .= "Felaktig användanamn och/eller lösenord";

		echo $this -> pageView -> getPage($title, $body);
		//}
	}

	/**
	 * doLogout
	 */
	public function doLogout() {
		//Shows to the user that he logged out
		if (isset($_GET["logout"])) {
			$this -> userName = "";
			$this -> password = "";

			setcookie("userNamecookie", "", time() - 120);
			/*expire in 2 minuter*/
			setcookie("passwordcookie", "", time() - 120);
			unset($_SESSION[self::LoggedIn]);

			$title = "Laboration 2 - Loggat ut";
			$body = $this -> getform();
			$body .= "Du har nu loggat ut";

			echo $this -> pageView -> getPage($title, $body);

		}
		//If the user is logged keeps him/her logged
		elseif (isset($_SESSION[self::LoggedIn]) && $_SESSION[self::LoggedIn] == TRUE) {

			$title = "Laboration 2";
			$body = "<h1>Laborationskod dd22ay</h1>
					<h2>Admin är Inloggad</h2>
					<a href='?logout'>Logga ut</a>";

			echo $this -> pageView -> getPage($title, $body);

		}
		//if user uses logout options shows the first page
		else {
			$title = 'Logga in';
			$body = getform();

			echo $this -> pageView -> getPage($title, $body);
		}
	}

	/**
	 * getuserName
	 * remember the Name of the user on Post
	 */
	public function getuserName() {
		if (isset($_POST[self::UserName])) {
			return $_POST[self::UserName];
		}
	}
	/**
	 * getpassword
	 * remember the password on Post
	 */
	public function getpassword() {
		if (isset($_POST[self::Password])) {
			return $_POST[self::Password];
		}
	}
	/**
	 * getAutologin
	 * if checkbox in the form
	 */
	public function getAutologin() {
		if (isset($_POST[self::Autologin])) {
			return $_POST[self::Autologin];
		}
	}

	/**
	 * doCheckin
	 * Looks if username and password is correct and save the user
	 */
	public function doCheckbox() {
		if (isset($_POST[self::Autologin])) {
			if ($this -> Autologin == $this -> getAutologin) {
				$this -> Autologin = 'Checked';
				$_SESSION[self::LoggedIn] = TRUE;

				$temp_Password = crypt("Password", "userName");
				setcookie("userNamecookie", "Admin", time() + 120);
				/*expire in 2minutes*/
				setcookie("passwordcookie", $temp_Password, time() + 120);

				$title = "Laboration 2";
				$body = "<h1>Laborationskod dd22ay</h1>
						<h2>Admin är Inloggad</h2>
						<p>
							Inloggning lyckades och vi kommer ihåg dig nästa gång.
						</p>
						
						<a href='?logout'>Logga ut</a>";

				echo $this -> pageView -> getPage($title, $body);
			}
		}
	}
	/**
	 * dosavedCookies
	 * if cookies is saved
	 */
	public function dosavedCookies() {
		if (!isset($_SESSION[self::LoggedIn]) && (isset($_COOKIE["userNamecookie"]) && isset($_COOKIE["passwordcookie"]))) {
			//var_dump($_COOKIE);
			$title = "Laboration 2";
			$body = "<h1>Laborationskod dd22ay</h1>
						<h2>Admin är Inloggad</h2>
						<p>
							Inloggning lyckades via cookie.
						</p>
						
						<a href='?logout'>Logga ut</a>";

			echo $this -> pageView -> getPage($title, $body);
		} else {
			$title = "Laboration 2 - Loggat ut";
			$body = $this -> getform();
			$body .= "Felaktig information i cookie";	

			echo $this -> pageView -> getPage($title, $body);
		}
	}

}
