<?php 
include '../koneksi.php'; //mentisipkan file koneksi
include '../function/function.php'; //menyisipkan file function

//mengambil data follow
$getDataFollow = follow($follower, $following);

?>