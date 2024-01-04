<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "story");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}
$LIMIT = 3;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>

<body>
    <?php

    $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
    if (!is_numeric($offset)) $offset = 0;

    $cari = isset($_GET['cari']) ? $_GET['cari'] : "";
    $cari_persen = "%" . $cari . "%";

    $sql = "Select * From cerita Where judul Like ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $cari_persen);
    $stmt->execute();
    $res = $stmt->get_result();
    $total_data = $res->num_rows;

    $sql = "Select * From cerita Where judul Like ? Limit ?,?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sii", $cari_persen, $offset, $LIMIT);
    $stmt->execute();
    $res = $stmt->get_result();

    echo "<div style='margin-bottom: 10px;'>";
    echo "<form method='get'>";
    echo "<label>Cari Judul</label> ";
    echo "<input type='text' name='cari'> ";
    echo "<button type='submit'>Cari</button>";
    echo "<br>";
    echo "<br>";
    echo "<button type='button' id='lanjut'>Buat Cerita Baru</button>"; // Menggunakan type 'button' bukan 'submit'
    echo "<br>";
    echo "</form>";

    // Menambahkan script JavaScript untuk mengarahkan ke 'login.php'
    echo "<script type='text/javascript'>";
    echo    "document.getElementById('lanjut').addEventListener('click', function() {";
    echo        "window.location.href = 'insertstory.php';"; //masih harus di ganti lagi
    echo    "});";
    echo "</script>";


    echo "<table border='3'>
	<tr> 
	  <th>Judul</th> <th>Pembuat Awal</th> <th>Aksi</th>
	</tr>";

    while ($row = $res->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['judul'] . "</td>";

        // Ambil nama pembuat awal dari tabel users
        $sql = "SELECT u.nama FROM cerita c INNER JOIN users u ON c.idusers_pembuat_awal = u.idusers WHERE c.idcerita = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $row['idcerita']);
        $stmt->execute();
        $res_nama_pembuat = $stmt->get_result();

        $row_nama_pembuat = $res_nama_pembuat->fetch_assoc();
        echo "<td>" . $row_nama_pembuat['nama'] . "</td>";


        // Tambahkan tombol aksi yang sesuai
        echo "<td>";
        echo "<a href='story.php?idcerita=" . $row['idcerita'] . "'>Lihat Cerita</a>";

        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";

    echo "<div>";
    $maks_page = ceil(($total_data + 1) / $LIMIT);
    for ($i = 1; $i <= $maks_page; $i++) {
        echo "<a href='home.php?offset=" . ($LIMIT * ($i - 1)) . "&cari=$cari'>$i</a> ";
    }
    echo "</div>";
    $mysqli->close();
    ?>
</body>

</html>