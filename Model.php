
<?php

/**
 *
 */

class Model {

	public static function db_connection() {

		$host = 'localhost';
		$dbname = 'registration';
		$user = 'root';
		$password = '123';
		$charset = 'utf8';

		$link = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $user, $password);

		return $link;
	}

	public static function close_db_connection($link) {

		$link = null;
	}

	public static function getLogin() {

		$link = self::db_connection();

		$result = $link->query("SELECT login FROM users");
		$data = [];
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

			$data[] = $row['login'];

		}

		return $data;
	}

	public static function getEmail() {

		$link = self::db_connection();

		$result = $link->query("SELECT email FROM users");
		$data = [];
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

			$data[] = $row['email'];

		}

		return $data;

	}

	public static function addUser($login, $email, $password) {

		$link = self::db_connection();

		$sql = 'INSERT INTO users (login,email,password)'
			. 'VALUES (:login, :email, :password)';

		$result = $link->prepare($sql);
		$result->bindParam(':login', $login, PDO::PARAM_STR);
		$result->bindParam(':email', $email, PDO::PARAM_STR);
		$result->bindParam(':password', $password, PDO::PARAM_STR);

		return $result->execute();

	}

}