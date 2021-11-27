<?php 
session_start(); //memulai session
include '../koneksi.php'; //menyisipkan file koneksi
include '../function/function.php'; //menyisipkan function

$id_register = $_SESSION['id_register'];

// mendapatkan data dari view
$result = getViewProfile($id_register);

//foto profile default
$default = "<img src='../assets/images/default.jpg'>";

//update foto baru
$update_foto = '<img src="data:image/jpeg;base64,'.base64_encode( $result["foto"] ).
'" alt="foto">';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="assets/css/style_profil.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- menyisipkan file navbar -->
    <?php include 'navbar.php'; ?>

    <div class='center'>
        <!-- foto profile -->
        <div class='profile_img'>
            <!-- jika foto belum di update maka foto akan default -->
            <?= $result['foto'] == NULL ? $default : $update_foto?>
        </div>

        <div class="formbx">
            <div class="username">
                <!-- echo username -->
                <?php echo $result['username'];?> 
                    <a href="edit_profile.php" class="<?= $id_register == $_SESSION['id_register']? '' : 'hide'?>">Edit Profil </a>    
            </div>
                
            <br><br>
                <div class="bio">
                    <!-- edit bio admin -->
                    <?php echo $result['bio']; ?> <a href="edit_bio.php" class="<?= $id_register == $_SESSION['id_register']? '' : 'hide'?>">Edit Bio </a>
                </div>
        </div>
    </div>
</body>
</html>