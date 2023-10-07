<?php
session_start();
//if (!isset($_SESSION['userid'])) header("location: login.php");
//if (!in_array("INSMV", $_SESSION['menu'])) header("location: index.php");

$mysqli = new mysqli("localhost", "root", "", "story");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <script type="text/javascript" src="js/jquery-3.7.1.js"></script>
    <style>
        .id {
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <form method='post' action='insertstory_proses.php' enctype="multipart/form-data">
        <p><label>Judul</label> <input type="text" name="judul" style=" width:25%; margin-left: 30px;"></p>
        <p><label>Paragraf</label> <input type="text" name="paragraf" style="width:25%; height:100px; margin-left: 10px;" /></p>
        <br>
        <p><input type="submit" name="btnsubmit" value="Simpan"></p>
    </form>
    <!-- <script type="text/javascript">
        $('body').on('click', '#tambah-pemain', function() {
            var id_pemain = $('#pemain').val();
            var nama_pemain = $('#pemain option:selected').text();
            var peran_pemain = $('#peran_pemain').val();
            var tombol_hapus = "<button type='button' class='hapus-pemain'>Hapus</button>";
            var pemain_baru = "<tr>";
            pemain_baru += "<td>" + nama_pemain + "<input type='hidden' name='idpemain[]' value='" + id_pemain + "'></td>";
            pemain_baru += "<td>" + peran_pemain + "<input type='hidden' name='peran[]' value='" + peran_pemain + "'></td>";
            pemain_baru += "<td>" + tombol_hapus + "</td>";
            pemain_baru += "</tr>";
            $('#list-pemain').append(pemain_baru);
        });
        $('body').on('click', '.hapus-pemain', function() {
            $(this).parent().parent().remove();
        });

        //$('.hapus-poster').click(function(){
        $('body').on('click', '.hapus-poster', function() {
            $(this).parent().remove();
        });
        $('#tambah-poster').click(function() {
            $('#container-poster').append("<div><input type='file' name='poster[]'><button type='button' class='hapus-poster'>Hapus</button></div>");
        });
    </script> -->
</body>

</html>
<?php $mysqli->close(); ?>