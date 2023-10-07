<?php  
require_once("parent.php");

class Movie extends Parentclass {
	public function __construct() {
		parent::__construct();
	}

	public function getMovie($cariJudul="", $offset=0, $limit=null) {
		$sql = "Select * From Movie Where judul Like ?";

		if(is_null($limit)) {
			$stmt=$this->mysqli->prepare($sql);
			$stmt->bind_param("s", $cariJudul);

		} else {
			$sql .= " Limit ?,?";
			$sql.= " Limit ?,?";
			$stmt=$this->mysqli->prepare($sql);
			$stmt->bind_param("sii", $cariJudul, $offset, $limit);
		}

		$stmt->execute();
		return $stmt->get_result();
	}

	public function insertMovie($arrData) {

		$judul = $arrData['judul'];
		$rilis = $arrData['rilis'];
		$skor = $arrData['skor'];
		$serial = $arrData['serial'];

		$sql = "Insert Into movie (judul, rilis, skor, serial) Values (?,?,?,?)";
		$stmt = $this->mysqli->prepare($sql);
		$stmt->bind_param("ssdi", $judul, $rilis, $skor, $serial);
		$stmt->execute();
		$idmovie = $stmt->insert_id;
		return $idmovie;
	}

	public function editMovie() { }
	public function deleteMovie() { }
}
