<?php
require_once("class/cerita.php");
// proses
$mysqli = new mysqli("localhost", "root", "", "story");

$story = new Cerita();
if (isset($_POST['submit'])) {

    $story->insertParagraf(); //harus di isi lagi dengan benar

}
