<?php 
include '../koneksi.php';
include '../function/function.php';

session_start();
if (!isset($_SESSION['id_register'])){
    header('location: ../login.php');
}

$show_Allpostingan_following = showPostinganFollowing($_SESSION['id_register']); 



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="assets/css/style.css">
    
    
</head>
<body>
	<?php include 'navbar.php' ?>

    
    <?php foreach($show_Allpostingan_following AS $postingFollowing){
            echo '<img src="data:image/jpeg;base64,'.base64_encode( $postingFollowing["gambar"] ).'" alt="foto">';
            echo $postingFollowing['pesan'];
            echo $postingFollowing['tanggal'];
        }   
    ?>
    
    
</body>
</html>