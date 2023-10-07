<?php  //registrasi_proses.php
require_once("class/users.php");

if(isset($_POST['signup'])) {
	$data = array();
	$data['userid']=$_POST['userid'];
	$data['nama']=$_POST['nama'];
	$data['password']=$_POST['password'];
	$data['password2']=$_POST['password2'];
	if($data['password'] == $data['password2']) {
		$users=new Users();
		$users->registrasi($data);
	} else {
		header("location: registrasi.php?error=pwd");
	}
}

header("location: registrasi.php");

?>