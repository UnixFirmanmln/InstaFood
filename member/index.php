<?php 
include '../koneksi.php';
include '../function/function.php';

session_start();
if (!isset($_SESSION['id_register'])){
    header('location: ../login.php');
}

$show_Allpostingan_following = showPostinganFollowing($_SESSION['id_register']); 

$id_register = $_SESSION['id_register'];
$sql = "SELECT * FROM view_profil WHERE id_register = $id_register";
$stm = $conn->query($sql);
$result = $stm->Fetch(PDO::FETCH_ASSOC);


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
                                        $result['username'].'
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