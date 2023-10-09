<?php
require_once("parent.php");

class Cerita extends Parentclass
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCerita($cariJudul = "", $offset = 0, $limit = null)
    {
        $sql = "Select * From cerita Where judul Like ?";

        if (is_null($limit)) {
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $cariJudul);
        } else {
            $sql .= " Limit ?,?";
            $sql .= " Limit ?,?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("sii", $cariJudul, $offset, $limit);
        }

        $stmt->execute();
        return $stmt->get_result();
    }

    public function insertCerita($arrData)
    {

        $judul = $arrData['judul'];
        $paragraf = $arrData['paragraf'];
        $idusers = $arrData['idusers'];

        $sql = "Insert Into cerita (judul, idusers) Values (?,?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("si", $judul, $idUser);
        $stmt->execute();
        $idcerita = $stmt->insert_id;
        return $idcerita;
    }

    public function insertParagraf()
    {
        //perlu di isi lagi
    }
}
