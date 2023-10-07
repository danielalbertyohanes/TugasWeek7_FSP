<?php
$mysqli = new mysqli("localhost", "root", "", "movie");
/*if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}*/
$LIMIT = 3;
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<style type="text/css">
		.rata-kanan {
			text-align: right;
		}

		.poster {
			max-width: 100px;
		}

		.teks-merah {
			color: red;
		}
	</style>
</head>

<body>
	<?php

	$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
	if (!is_numeric($offset)) $offset = 0;

	$cari = isset($_GET['cari']) ? $_GET['cari'] : "";
	$cari_persen = "%" . $cari . "%";

	$sql = "Select * From Movie Where judul Like ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s", $cari_persen);
	$stmt->execute();
	$res = $stmt->get_result();
	$total_data = $res->num_rows;

	$sql = "Select * From Movie Where judul Like ? Limit ?,?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("sii", $cari_persen, $offset, $LIMIT);
	$stmt->execute();
	$res = $stmt->get_result();

	echo "<div style='margin-bottom: 10px;'>";
	echo "<form method='get'>";
	echo "<label>Masukkan judul</label> ";
	echo "<input type='text' name='cari'> ";
	echo "<button type='submit'>Cari</button>";
	echo "</form>";
	if (isset($_GET['cari'])) echo "<p><i>Hasil pencarian untuk '" . $_GET['cari'] . "'</i></p>";
	echo "</div>";

	echo "<table border='1'>
	<tr> 
	  <th>Poster</th> <th>Judul</th>
		<th>Genre</th> <th>Tgl. Rilis</th>
		<th>Skor</th> <th>Serial</th> 
	</tr>";

	while ($row = $res->fetch_assoc()) {


		if ($row['skor'] < 5) {
			echo "<tr class='teks-merah'>";
		} else {
			echo "<tr> ";
		}
		echo "<td>
		<img class='poster' src='poster/" . $row['idmovie'] . "." . $row['extention'] . "'>
		</td>";
		echo "<td>" . $row['judul'] . "</td>";
		echo "<td>";
		$sql = "Select g.nama From genre g Inner Join genre_movie gm On g.idgenre=gm.idgenre Where gm.idmovie=?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("i", $row['idmovie']);
		$stmt->execute();
		$res_genre = $stmt->get_result();
		echo "<ul>";

		while ($row_genre = $res_genre->fetch_assoc()) {
			echo "<li>" . $row_genre['nama'] . "</li>";
		}
		echo "</ul>";
		echo "</td>";
		echo "<td>" . $row['rilis'] . "</td>";
		echo "<td class='rata-kanan'>" . $row['skor'] . "</td>";
		echo "<td>" . ($row['serial'] ? "Ya" : "Tidak") . "</td>";
		echo "</tr>";
	}

	echo "</table>";

	echo "<div>";
	$maks_page = ceil($total_data / $LIMIT);
	for ($i = 1; $i < $maks_page; $i++) {
		echo "<a href='index.php?offset=" . ($LIMIT * ($i - 1)) . "&cari=$cari'>$i</a> ";
	}
	echo "</div>";
	$mysqli->close();
	?>
</body>

</html>