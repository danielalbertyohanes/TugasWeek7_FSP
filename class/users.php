<?php  
require_once("parent.php");
session_start();

class Users extends Parentclass {
	public function __construct() {
		parent::__construct();
	}
	private function generateSalt() {
		return substr(sha1(date("YmdHis")), 0, 10);
	}
	private function EncryptPassword($plainPwd, $salt) {
		return sha1(sha1($plainPwd).$salt);
	}
	private function getSalt($idusers) {
		$sql="Select salt From users Where idusers=?";
		$stmt=$this->mysqli->prepare($sql);
		$stmt->bind_param("s", $idusers);
		$stmt->execute(); 
		$res = $stmt->get_result();
		if($row=$res->fetch_assoc())
			return $row['salt'];
		else return "";
	}
	private function generateSession($row){
		$_SESSION['idusers'] = $row['idusers'];
		$_SESSION['nama'] = $row['nama'];

	}
	public function login($idusers, $pwd) {
		$salt = $this->getSalt($idusers);
		$encPwd = $this->EncryptPassword($pwd, $salt);
		$sql="Select * From users Where idusers=? And password=?";
		$stmt=$this->mysqli->prepare($sql);
		$stmt->bind_param("ss", $idusers, $encPwd);		
		$stmt->execute(); 
		$res = $stmt->get_result();
		if($res->num_rows > 0){
			$this->generateSession($res->fetch_assoc());
			return "sukses";
		} else "gagal";
	}
	public function registrasi($arrData) {
		$salt = $this->generateSalt();
		$encPwd = $this->EncryptPassword($arrData['password'], $salt);
		$sql="Insert into users Values (?,?,?,?)";
		$stmt=$this->mysqli->prepare($sql);
		$stmt->bind_param("ssss", $arrData['idusers'], $arrData['nama'], $encPwd, $salt);
		$stmt->execute();
	}
}
