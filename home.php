<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "story");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}

$idusers = $_SESSION['idusers'];
$offset = 0;
$LIMIT_KUMPULAN = 4;
$LIMIT_CERITAKU = 2;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cerbung App</title>
    <link rel="stylesheet" href="style.css">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="ajax-paging.js"></script>

    <script>
        $(document).ready(function() {
            var offsetKumpulan = 4;
            var limitKumpulan = 4;
            var offsetCeritaku = 2;
            var limitCeritaku = 2;

            // function toggleCategoryView(category) {
            //     if (category === 'kumpulancerita') {
            //         $('#ceritaku').hide();
            //         $('#kumpulancerita').show();
            //     } else if (category === 'ceritaku') {
            //         $('#kumpulancerita').hide();
            //         $('#ceritaku').show();
            //     }
            // }

            // // Pilih opsi default pada halaman pertama kali dimuat


            // $('#idceritaku').on('change', function() {
            //     var selectedCategory = $(this).val();
            //     toggleCategoryView(selectedCategory);
            // });
            // $('#idkumpulan').on('change', function() {
            //     var selectedCategory = $(this).val();
            //     toggleCategoryView(selectedCategory);
            // });


            // Load more for Kumpulan Cerita
            $('#lanjutKumpulan').on('click', function() {
                $.ajax({
                    type: 'GET',
                    url: 'load_more.php',
                    data: {
                        offset: offsetKumpulan,
                        limit: limitKumpulan,
                        category: 'kumpulancerita'
                    },
                    success: function(data) {
                        $('.card-container1').append(data);
                        offsetKumpulan += limitKumpulan;
                    }
                });
            });

            // Load more for Ceritaku
            $('#lanjutCeritaku').on('click', function() {
                $.ajax({
                    type: 'GET',
                    url: 'load_more.php',
                    data: {
                        offset: offsetCeritaku,
                        limit: limitCeritaku,
                        category: 'ceritaku'
                    },
                    success: function(data) {
                        $('.card-container2').append(data);
                        offsetCeritaku += limitCeritaku;
                    }
                });
            });
        });
    </script>
</head>

<body>
    <div id="container">
        <div id="kumpulancerita">
            <header>
                <h1 style="font-weight: bold; margin-top: 0px; margin-bottom: 0px">CERBUNG</h1>
                <h4 style="margin-top: 0px">Cerita Bersambung</h4>
            </header>

            <main>
                <form method='get'>
                    <label>Kategori:</label>
                    <br>
                    <select name="idcerita" id="idkumpulan">
                        <option value='kumpulancerita' style='color: red;'>Kumpulan Cerita</option>
                        <?php
                        $sql = "SELECT c.*, u.nama FROM cerita c INNER JOIN users u ON u.idusers = c.idusers_pembuat_awal WHERE idusers_pembuat_awal != ?";
                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param("s", $idusers);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        while ($row = $res->fetch_assoc()) {
                            echo "<option value='{$row['idcerita']}' style='color: red;'>{$row['judul']}</option>";
                        }
                        ?>
                    </select>
                </form>
                <h2>Kumpulan Cerita</h2>
                <div class="card-container1">
                    <?php
                    $sql = "SELECT c.*, u.nama FROM cerita c INNER JOIN users u ON u.idusers = c.idusers_pembuat_awal WHERE idusers_pembuat_awal != ? LIMIT ?,?";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("sii", $idusers, $offset, $LIMIT_KUMPULAN);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    while ($row = $res->fetch_assoc()) {
                        $sql_paragraf = "SELECT COUNT(*) AS total_paragraf FROM paragraf WHERE idcerita = ?";
                        $stmt_paragraf = $mysqli->prepare($sql_paragraf);
                        $stmt_paragraf->bind_param("i", $row['idcerita']);
                        $stmt_paragraf->execute();
                        $res_paragraf = $stmt_paragraf->get_result();
                        $row_paragraf = $res_paragraf->fetch_assoc();

                        echo "<div class='card' style='border:1px 1px solid #ccc;'>";
                        echo "<h2>{$row['judul']}</h2>";
                        echo "<h4>Pemilik Cerita: {$row['nama']}</h4>";
                        echo "<h4>Jumlah Paragraf: {$row_paragraf['total_paragraf']}</h4>";
                        echo "<a href='read.php?idcerita={$row['idcerita']}'>Baca Lebih Lanjut</a>";
                        echo "</div>";
                    }
                    ?>
                </div>
                <button type='button' id='lanjutKumpulan'>Tampilkan Cerita Selanjutnya</button>
            </main>
        </div>

        <div id="ceritaku">
            <header>
                <h1 style="font-weight: bold; margin-top: 0px; margin-bottom: 0px">CERBUNG</h1>
                <h4 style="margin-top: 0px">Cerita Bersambung</h4>
            </header>
            <main>
                <form method='get'>
                    <label>Kategori:</label>
                    <br>
                    <select name="idcerita" id="idceritaku">
                        <option value='ceritaku' style='color: red;'>Ceritaku</option>
                        <?php
                        $sql = "SELECT c.*, u.nama FROM cerita c INNER JOIN users u ON u.idusers = c.idusers_pembuat_awal WHERE idusers_pembuat_awal = ?";
                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param("s", $idusers);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        while ($row = $res->fetch_assoc()) {
                            echo "<option value='{$row['idcerita']}' style='color: red;'>{$row['judul']}</option>";
                        }
                        ?>
                    </select>
                </form>
                <h2>Cerita Ku</h2>
                <div class="card-container2">
                    <?php
                    $sql = "SELECT c.*, u.nama FROM cerita c INNER JOIN users u ON u.idusers = c.idusers_pembuat_awal WHERE idusers_pembuat_awal = ? LIMIT ?,?";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("sii", $idusers, $offset, $LIMIT_CERITAKU);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    while ($row = $res->fetch_assoc()) {
                        $sql_paragraf = "SELECT COUNT(*) AS total_paragraf FROM paragraf WHERE idcerita = ?";
                        $stmt_paragraf = $mysqli->prepare($sql_paragraf);
                        $stmt_paragraf->bind_param("i", $row['idcerita']);
                        $stmt_paragraf->execute();
                        $res_paragraf = $stmt_paragraf->get_result();
                        $row_paragraf = $res_paragraf->fetch_assoc();

                        echo "<div class='card' style='border:1px 1px solid #ccc;'>";
                        echo "<h2>{$row['judul']}</h2>";
                        echo "<br>";
                        echo "<h4>Jumlah Paragraf: {$row_paragraf['total_paragraf']}</h4>";
                        echo "<a href='read.php?idcerita={$row['idcerita']}'>Baca Lebih Lanjut</a>";
                        echo "</div>";
                    }
                    ?>
                </div>
                <button type='button' id='lanjutCeritaku'>Tampilkan Cerita Selanjutnya</button>
            </main>
        </div>
    </div>
</body>

</html>