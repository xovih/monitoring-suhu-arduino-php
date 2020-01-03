<?php
include_once 'config.php';
date_default_timezone_set("Asia/Jakarta");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $suhucelcius    = $_POST['suhu'];
    $lembap         = $_POST['kelembapan'];
    $kodeagen       = $_POST['agent'];
    $datetime       = date('Y-m-d H:i:s');

    $insert = $mysqli->query("INSERT INTO suhuku SET waktu='$datetime', kelembapan='$lembap', suhu='$suhucelcius', kode_agent='$kodeagen'");

    if ($insert) {
        echo "Sukses insert data";
    }
} else {
    echo "Request Tidak Valid";
}