<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Cerita</title>
    <script type="text/javascript" src="js/jquery-3.7.1.js"></script>
    <style>
        .id {
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <form method='post' action='insertstory_proses.php' enctype="multipart/form-data">
        <?php
        $idusers = $_SESSION['idusers'];
        echo "$idusers";
        ?>
        <p><label>Judul</label> <input type="text" name="judul" style=" width:25%; margin-left: 30px;"></p>
        <p><label>Paragraf</label> <textarea name="paragraf" style=" margin-left: 10px;"></textarea></p>
        <br>
        <p><input type="submit" name="btnsubmit" value="Simpan"></p>
        <br>
        <a href='home.php'>&lt;&lt; Kembali Ke Halaman Awal</a>
    </form>
</body>

</html>