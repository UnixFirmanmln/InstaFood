<?php 
include '../koneksi.php'; //menyisipkan file koneksi
include '../function/function.php'; //menyisipkan file function

session_start(); //memulai session

// kondisi jika ada session id_register maka akan dirahkan ke index member
if (!isset($_SESSION['id_register'])){
    header('location: ../login.php');
}

//menampilkan semua posting yang difollow(diikuti)
$id_register = $_SESSION['id_register'];
$show_Allpostingan_following  = showUsernamePostinganFollowing($id_register);

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
    <!-- menyisipkan file navbar -->
	<?php include 'navbar.php' ?> 

    <!-- perulangan untuk menampikan postingan member-->
    <?php foreach($show_Allpostingan_following AS $postingFollowing){
            echo '
                <div class="center">
                    <div class="border">
                        <div class="line"></div>
                        <div class="posting">    
                            <img src="data:image/jpeg;base64,'.base64_encode( $postingFollowing["gambar"] ).'" alt="foto">
                            <br>';

                            echo '
                                <div class="containerbx">
                                    <div class="username_posting">'.
                                        $postingFollowing['username'].'
                                    </div>

                                    <div class="tgl">'.
                                        $postingFollowing['tanggal'].'
                                    </div>
                                </div>';

                            echo '
                                <div class="pesan">'.   
                                    $postingFollowing['pesan'].'
                                </div>
                        </div>
                        <div class="line"></div>
                    </div>
                </div>';
           
        }   
    ?>
    
    
</body>
</html>