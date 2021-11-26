<?php 
    include '../koneksi.php';
    include '../function/function.php';
    session_start();

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
    <h1>Hasil Search:</h1> 
    <?php foreach (searchMember() as $search) {
        echo "
            <div class='containerhasil'>
                <a href='profile.php?id=".$search['id_register']."'>".$search['username'].'</a>
            </div>';
    } ?>
</body>
</html>