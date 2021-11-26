<?php 
session_start();
include '../koneksi.php';
include '../function/function.php';

if(!isset($_GET['id'])){
    $id_register = $_SESSION['id_register'];
    $save = false; //jika masuk profil diri sendiri maka follow sama unfollownya akan di hide
} else {
    $id_register = $_GET['id'];

    //buat mengecek apakah sudah menemukan atau belum. Jika ditemukan maka sudah difollow jika belum maka sebaliknya
    $save = getDataTblFollowers($id_register)->rowCount() > 0;

}

$result = getViewProfile($id_register);

$default = "<img src='../assets/images/default.jpg'>";
// var_dump($id_register); die
$update_foto = '<img src="data:image/jpeg;base64,'.base64_encode( $result["foto"] ).
'" alt="foto">';

//untuk menampung jumlah posting
$jml_posting = showCountPosting($id_register);

//untuk menampung jumlah follower/pengikut
$jml_follower = showCountFollower($id_register);

//untuk menampung jumlah following/yang diikuti
$jml_following = showCountFollowing($id_register);

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
    <?php include 'navbar.php' ?>

    <div class='center'>

        <div class='profile_img'>
            <?= $result['foto'] == NULL ? $default : $update_foto?>
        </div>

        <div class="formbx">
            <div class="username">
                <?php echo $result['username'];?> <a href="edit_profile.php" class="<?= $id_register == $_SESSION['id_register']? '' : 'hide'?>">Edit Profil </a>
                <?php if($save) : ?>
                    <a href="unfollow.php?id_register=<?= $_SESSION['id_register'] ?>&id_followed=<?= $id_register ?>" class="<?= $id_register == $_SESSION['id_register']? 'hide' : ''?>"> Unfollow </a>
                <?php else : ?> 
                    <a href="follow.php?id_register=<?= $_SESSION['id_register'] ?>&id_followed=<?= $id_register ?>" class="<?= $id_register == $_SESSION['id_register']? 'hide' : ''?>">Follow</a>
                <?php endif ?>
            </div>
                
            <?= $jml_posting['jml_posting'] ?> kiriman
            <?= $jml_follower['jml_follower'] ?> pengikut
            <?= $jml_following['jml_following'] ?> diikuti
            
            
            
            <br><br>

            <div class="bio">
                <?php echo $result['bio']; ?> <a href="edit_bio.php" class="<?= $id_register == $_SESSION['id_register']? '' : 'hide'?>">Edit Bio </a>
            </div>
        </div>
             
    </div>

    <div class="center">
        <div class="border">
            <?php foreach(showPostinganMember($id_register) as $posting) : 
                echo '
                    <div class="line"></div>
                    <div class="posting">
                        <img src="data:image/jpeg;base64,'.base64_encode( $posting["gambar"] ).'" alt="Status">
                        <br>';
             
                        echo '
                        <div class="containerbx">
                            <div class="username_posting">'.
                                $result['username'].'
                            </div>
                            
                            <div class="tgl">'.
                                $posting['tanggal'].'
                            </div>
                        </div>';
                
                        echo '
                        <div class="pesan">'.
                            $posting['pesan'].'
                        </div>
                    </div>'; ?>
                <div class="line"></div>
            <?php endforeach ?>
         
        </div>
        <!-- <a href="tambah_posting.php">Tambah Posting</a> -->
    </div>
    
    

</body>
</html>