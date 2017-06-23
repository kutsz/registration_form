<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

class ValidationController {

	public $arrError = [];

	public $login = '';
	public $email = '';
	public $password = '';
	public $confirm_password = '';

	// public function __construct($login, $email, $password, $confirm_password) {

	// 	$this->login = $this->input($login);
	// 	$this->email = $this->input($email);
	// 	$this->password = $this->input($password);
	// 	$this->confirm_password = $this->input($confirm_password);

	// }

	public function showForm() {
		require 'form.php';
	}

	public function input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); //htmlentities()
		return $data;
	}

	public function is_valid_login($login) {

		if (empty($login)) {

			$this->arrError[] = 'login is required';
			return false;

		} else {

			$login1 = $this->input($login);

			if (!preg_match('/^\w{5,}$/', $login1)) {

				$this->arrError[] = 'login Must Contain At Least 5 Characters';
				return false;
			}

		}

		$this->login = $login1;
		return true;

	}

	public function is_valid_email($email) {

		if (empty($email)) {

			$this->arrError[] = 'Email is required';
			return false;

		} else {

			$email1 = $this->input($email);

			if (!filter_var($email1, FILTER_VALIDATE_EMAIL)) {
				$this->arrError[] = 'Invalid email format';
				return false;
			}
		}
		$this->email = $email1;
		return true;
	}

	public function is_valid_password($password, $confirm_password) {

		if (empty($password)) {
			$this->arrError[] = 'Please enter password';
			return false;

		} else {

			$password1 = $this->input($password);

			if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $password1)) {
				$this->arrError[] = "Your Password Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters";
				return false;
			}

		}

		if (empty($confirm_password)) {

			$this->arrError[] = 'Please comfirm password!';
			return false;
		} elseif ($password != $confirm_password) {

			$this->arrError[] = 'Passwords do not match!';
			return false;

		}
		$this->password = $password1;
		return true;

	}

	// public function is_valid_password($password, $confirm_password) {

	// 	if (empty($password)) {
	// 		$this->arrError[] = 'Please enter password';
	// 		return false;

	// 	} elseif (empty($confirm_password)) {

	// 		$this->arrError[] = 'Please comfirm password!';
	// 		return false;
	// 	} elseif ($password != $confirm_password) {

	// 		$this->arrError[] = 'Passwords do not match!';
	// 		return false;

	// 	} elseif (!empty($password)) {

	// 		//$password = $this->input($_POST["password"]);

	// 		if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $password)) {
	// 			$this->arrError[] = "Your Password Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters";
	// 			return false;
	// 		}

	// 	}

	// 	return true;

	// }

	public function showMessage() {

		if (empty($this->arrError)) {
			echo 'OK';

		} else {

			foreach ($this->arrError as $value) {

				echo $value . '<br>';

			}

		}

	}

	public function show_var() {

		echo $this->login . '<br>';
		echo $this->email . '<br>';
		echo $this->password . '<br>';
		//echo $this->confirm_password . '<br>';

	}

	public function loginUnique($login) {

		$loginList = Model::getLogin();
		$flag = true;

		foreach ($loginList as $loginItem) {
			if ($login == $loginItem) {
				$flag = false;
				break;
			}
		}

		if (!$flag) {
			$this->arrError[] = 'login not unique';
		}

		return $flag;

	}

	public function emailUnique($email) {

		$emailList = Model::getEmail();
		$flag = true;

		foreach ($emailList as $emailItem) {
			if ($email == $emailItem) {
				$flag = false;
				break;
			}
		}

		if (!$flag) {
			$this->arrError[] = 'Email not unique';
		}

		return $flag;
	}

}
