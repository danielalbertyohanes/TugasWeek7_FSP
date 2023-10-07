<?php
session_start();
if (!isset($_SESSION['userid'])) header("location: login.php");
if (!in_array("INSMV", $_SESSION['menu'])) header("location: index.php");

$mysqli = new mysqli("localhost", "root", "", "movie");
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<script type="text/javascript" src="js/jquery-3.7.1.js"></script>
</head>

<body>
	<form method='post' action='insertmovie_proses.php' enctype="multipart/form-data">
		<p><label>Judul</label> <input type="text" name="judul"></p>
		<p><label>Rilis</label> <input type="date" name="rilis"></p>
		<p><label>Skor</label> <input type="number" name="skor" step="any"></p>
		<p><label>Serial?</label> <input type="checkbox" name="serial" value="1" id="serial"> <label for="serial">Ya</label></p>
		<p><label>Genre</label>
			<?php
			$sql = "Select * From genre";
			$stmt = $mysqli->prepare($sql);
			$stmt->execute();
			$res = $stmt->get_result();
			while ($row = $res->fetch_assoc()) {
				echo "<input type='checkbox' name='genre[]' value='" . $row['idgenre'] . "' id='" . $row['nama'] . "'> 
		<label for='" . $row['nama'] . "'>" . $row['nama'] . "</label>";
			}
			?>
		</p>
		<p><label>Poster</label>
		<div id="container-poster">
			<div><input type="file" name="poster[]"><button type="button" class='hapus-poster'>Hapus</button></div>
		</div>
		<button type="button" id="tambah-poster">Tambah Poster</button>
		</p>
		<p><label>Pemain</label>
		<div style='margin-bottom: 10px;'>
			<select id="pemain">
				<?php
				$sql = "Select * From pemain";
				$stmt = $mysqli->prepare($sql);
				$stmt->execute();
				$res = $stmt->get_result();
				while ($row = $res->fetch_assoc()) {
					echo "<option value='" . $row['idpemain'] . "'>" . $row['nama'] . "</option>";
				}
				?>
			</select>
			<select id="peran_pemain">
				<option value="Utama">Utama</option>
				<option value="Pembantu">Pembantu</option>
				<option value="Cameo">Cameo</option>
			</select>
			<button type='button' id='tambah-pemain'>Tambah</button>
		</div>
		<div>
			<table border='1'>
				<thead>
					<tr>
						<th>Pemain</th>
						<th>Peran</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody id='list-pemain'>
				</tbody>
			</table>
		</div>
		</p>
		<p><input type="submit" name="btnsubmit" value="Simpan"></p>
	</form>
	<script type="text/javascript">
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
	</script>
</body>

</html>
<?php $mysqli->close(); ?>