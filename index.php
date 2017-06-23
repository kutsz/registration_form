<?php

require 'ValidationController.php';
require 'Model.php';

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);

$valid = new ValidationController();

$valid->showForm();

if (isset($_POST['submit'])) {

	$loginFlag = $valid->is_valid_login($_POST['login']);

	$emailFlag = $valid->is_valid_email($_POST['email']);

	$passwordFlag = $valid->is_valid_password($_POST['password'], $_POST['confirm_password']);

	$loginUniqueFlag = $valid->loginUnique($valid->login);

	$emailUniqueFlag = $valid->emailUnique($valid->email);

	if ($loginFlag && $emailFlag && $passwordFlag && $loginUniqueFlag && $emailUniqueFlag) {

		$passwordHash = password_hash($valid->password, PASSWORD_DEFAULT, ['cost' => 12]);

		if ($passwordHash !== false) {
			Model::addUser($valid->login, $valid->email, $passwordHash);
		}

	}

	$valid->showMessage();

}
