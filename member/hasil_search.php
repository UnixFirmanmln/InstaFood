<?php 
    include '../koneksi.php';
    session_start();
    $cari =  $_GET['member'];
    $query_search = "SELECT * FROM register WHERE username LIKE '%$cari%'";
    $ext_search = $conn->prepare($query_search);
    $ext_search->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Hasil Pencarian</title>
</head>
<body>
    <?php include 'navbar.php' ?>
    <h1>Ini Page Hasil Search</h1>
    <?php foreach ($ext_search as $search) {
        echo "<a href='profile.php?id=".$search['id_register']."'>".$search['username'].'</a>';
    } ?>
</body>
</html>