<?php 
session_start(); //memulai session
session_destroy(); //menghapus seluruh session
header('location: index.php'); //menuju index
?>