<?php
session_start();
//if (!isset($_SESSION['userid'])) header("location: login.php");
//if (!in_array("INSMV", $_SESSION['menu'])) header("location: index.php");

$mysqli = new mysqli("localhost", "root", "", "story");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>story</title>
</head>

<body>
    <form action="story_proses.php" method="post">
        <h1>Judul</h1>
        <div style="margin-left: 0%; margin-right: 10%">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas molestiae accusantium ut fuga? Libero, quae? Mollitia accusamus hic earum natus quas, magnam libero ullam nobis totam! Quam, eaque? Laboriosam, ad.</p>
        </div>

        <label for="">Tambah paragraf</label>
        <br>
        <textarea name="" id="" cols="30" rows="10"></textarea>
        <br>
        <button type="submit" name='btnSubmit'>simpan</button>
        <br>
        <a href='index.php'>
            << Kembali Ke Halaman Awal </a>
    </form>
</body>

</html>
<?php $mysqli->close(); ?>