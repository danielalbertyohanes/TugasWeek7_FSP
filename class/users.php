<?php  
require_once("parent.php");
require_once("menu.php");
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
	private function getSalt($userid) {
		$sql="Select salt From users Where userid=?";
		$stmt=$this->mysqli->prepare($sql);
		$stmt->bind_param("s", $userid);
		$stmt->execute(); 
		$res = $stmt->get_result();
		if($row=$res->fetch_assoc())
			return $row['salt'];
		else return "";
	}
	private function generateSession($row){
		$_SESSION['userid'] = $row['userid'];
		$_SESSION['nama'] = $row['nama'];

		$menu = new Menu();
		$res=$menu->getMenuProfil($row['idprofil']);
		$arr_menu=array();
		while($row_menu=$res->fetch_assoc()) {
			$arr_menu[]=$row_menu['idmenu'];
		}
		$_SESSION['menu'] = $arr_menu;
	}
	public function login($userid, $pwd) {
		$salt = $this->getSalt($userid);
		$encPwd = $this->EncryptPassword($pwd, $salt);
		$sql="Select * From users Where userid=? And password=?";
		$stmt=$this->mysqli->prepare($sql);
		$stmt->bind_param("ss", $userid, $encPwd);		$stmt->execute(); 
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
		$stmt->bind_param("ssss", $arrData['userid'], $arrData['nama'], $encPwd, $salt);
		$stmt->execute();
	}
}

?>