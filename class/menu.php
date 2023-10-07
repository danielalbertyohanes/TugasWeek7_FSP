<?php 
require_once("parent.php");

class Menu extends Parentclass {
	public function __construct() {
		parent::__construct();
	}

	public function getMenuProfil($idprofil) {
		$sql="Select * From menu_has_profil Where idprofil=?";
		$stmt=$this->mysqli->prepare($sql);
		$stmt->bind_param("s", $idprofil);
		$stmt->execute();  		
		$res= $stmt->get_result();
		return $res;
	}

	public function getMenu() {

	}
}
?>