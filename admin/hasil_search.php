<?php 
    include '../koneksi.php'; //menyisipkan file koneksi
    include '../function/function.php'; //menyisipkan file function
    session_start(); //memulai session

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
    <!-- menyisipkan file navbar -->
    <?php include 'navbar.php' ?>
    <h1>Hasil Search:</h1> 

    <!-- perulangan untuk menampikan data member dan admin -->
    <?php foreach (searchAdmin($_GET['member']) as $search) {
        //untuk menampung jumlah posting
        $jml_posting = showCountPosting($search['id_register']);

        //untuk menampung jumlah follower/pengikut
        $jml_follower = showCountFollower($search['id_register']);

        //untuk menampung jumlah following/yang diikuti
        $jml_following = showCountFollowing($search['id_register']);

        // menampilkan data member dan admin
        echo "
            <div class='containerhasil'>
                <div class='search_item'>
                    <div class='flex_img_usr'>";    
                        if ($search['foto'] == NULL) {
                            echo "
                                <div class='img_profile_search'>
                                    <img src='../assets/images/default.jpg'>
                                </div>";
                        } else {
                            echo '
                                <div class="img_profile_search">
                                    <img src="data:image/jpeg;base64,'.base64_encode( $search["foto"] ).'" alt="foto">
                                </div>';
                        }
                    
                        echo "
                            <div class='flex_usr_info'>
                                <a href='../member/profile.php?id=".$search['id_register']."' class='usr_search'>".$search['username'].'
                                </a>';     
                            
                        echo '
                                <div class="info_follower">'. 
                                    $jml_posting['jml_posting']." kiriman &nbsp;&nbsp;".$jml_follower['jml_follower']." pengikut &nbsp;&nbsp;".$jml_following['jml_following']." diikuti
                                </div>
                            </div>
                    </div>
                </div>
            </div>'";
    } ?>
   
</body>
</html>

