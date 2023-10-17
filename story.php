<?php
session_start();
//if (!isset($_SESSION['userid'])) header("location: login.php");
//if (!in_array("INSMV", $_SESSION['menu'])) header("location: index.php");

$mysqli = new mysqli("localhost", "root", "", "story");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}
if (isset($_GET['idcerita'])) {
    $idcerita = $_GET['idcerita'];

    // Query untuk mengambil data cerita berdasarkan ID cerita
    $sql = "SELECT * FROM cerita c inner join paragraf p on c.idcerita = p.idcerita WHERE c.idcerita = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $idcerita);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $judul = $row['judul'];
        echo "<h1>$judul</h1>";
        $paragraf = $row['isi_paragraf'];
        echo "<p style='margin-left: 0%; margin-right: 10%; text-aligment: justify;'>$paragraf</p>";
        $row = null;
        while ($row = $res->fetch_assoc()) {
            $paragraf = $row['isi_paragraf'];
            echo "<p style=' font-size: Large; margin-left: 0%; margin-right: 10%; text-align: justify;'>$paragraf</p>";
        }
    } else {
        echo "Cerita tidak ditemukan.";
    }
} else {
    echo "Parameter ID cerita tidak ditemukan.";
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>story</title>
    <style>
        .p {
            font-size: medium;
            text-align: justify;
        }
    </style>
</head>

<body>
    <form action="story_proses.php" method="post">
        <br>
        <br>
        <label for="">Tambah paragraf</label>
        <br>
        <textarea name="paragraf" cols="30" rows="10"></textarea>
        <!-- Tambahkan hidden input untuk menyimpan ID cerita -->
        <input type="hidden" name="idcerita" value="<?php echo $idcerita; ?>">
        <br>
        <button type="submit" name="btnSubmit">Simpan</button>
        <br>
        <a href='home.php'>&lt;&lt; Kembali Ke Halaman Awal</a>
    </form>
</body>

</html>