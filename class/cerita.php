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
        $iduser = $arrData['idusers'];
        $tanggal = $arrData['tanggal'];

        $sql = "INSERT INTO `story`.`cerita` (`judul`, `idusers_pembuat_awal`) VALUES (?, ?);";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ss", $judul, $iduser); // Menghapus double dollar sign
        $stmt->execute();
        $idcerita = $stmt->insert_id;

        $paragraf_sql = "INSERT INTO `story`.`paragraf` (`isi_paragraf`, `tanggal_buat`, `idcerita`, `idusers`) VALUES (?,?,?,?);";
        $paragraf_stmt = $this->mysqli->prepare($paragraf_sql);
        $paragraf_stmt->bind_param("ssis", $paragraf, $tanggal, $idcerita, $iduser); // Mengubah "s" menjadi "i" untuk idcerita
        $paragraf_stmt->execute();
        $idparagraf = $paragraf_stmt->insert_id;

        return $idcerita;
    }


    public function insertParagraf($arrData)
    {
        $paragraf = $arrData['paragraf'];
        $iduser = $arrData['idusers'];
        $tanggal = $arrData['tanggal'];
        $idcerita = $arrData['idcerita'];

        $paragraf_sql = "INSERT INTO `story`.`paragraf` (`isi_paragraf`, `tanggal_buat`, `idcerita`, `idusers`) VALUES (?,?,?,?);";
        $paragraf_stmt = $this->mysqli->prepare($paragraf_sql);
        $paragraf_stmt->bind_param("ssis", $paragraf, $tanggal, $idcerita, $iduser); // Mengubah "s" menjadi "i" untuk idcerita
        $paragraf_stmt->execute();
        $idparagraf = $paragraf_stmt->insert_id;

        return $idparagraf;
    }
}
