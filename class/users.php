<?php

require_once("parent.php");

class Users extends Parentclass
{
	public function __construct()
	{
		parent::__construct();

		// Check if a session is already active before starting a new one
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
	}

	private function generateSalt()
	{
		return substr(sha1(date("YmdHis")), 0, 10);
	}

	private function EncryptPassword($plainPwd, $salt)
	{
		return sha1(sha1($plainPwd) . $salt);
	}

	private function getSalt($idusers)
	{
		$sql = "SELECT salt FROM users WHERE idusers=?";
		$stmt = $this->mysqli->prepare($sql);
		$stmt->bind_param("s", $idusers);
		$stmt->execute();
		$res = $stmt->get_result();
		if ($row = $res->fetch_assoc()) {
			return $row['salt'];
		} else {
			return "";
		}
	}

	private function generateSession($row)
	{
		$_SESSION['idusers'] = $row['idusers'];
		$_SESSION['nama'] = $row['nama'];
	}

	public function login($idusers, $pwd)
	{
		$salt = $this->getSalt($idusers);
		$encPwd = $this->EncryptPassword($pwd, $salt);
		$sql = "SELECT * FROM users WHERE idusers=? AND password=?";
		$stmt = $this->mysqli->prepare($sql);
		$stmt->bind_param("ss", $idusers, $encPwd);
		$stmt->execute();
		$res = $stmt->get_result();
		if ($res->num_rows > 0) {
			$this->generateSession($res->fetch_assoc());
			return "sukses";
		} else {
			return "gagal";
		}
	}

	public function registrasi($arrData)
	{
		$salt = $this->generateSalt();
		$encPwd = $this->EncryptPassword($arrData['password'], $salt);
		$sql = "INSERT INTO users (idusers, nama, password, salt) VALUES (?,?,?,?)";
		$stmt = $this->mysqli->prepare($sql);
		if (!$stmt) {
			die("Error in SQL query: " . $this->mysqli->error);
		}
		$stmt->bind_param("ssss", $arrData['idusers'], $arrData['nama'], $encPwd, $salt);
		$stmt->execute();
	}
}
