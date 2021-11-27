<?php 

session_start(); //memulai session
include '../koneksi.php'; //menyisipkan file koneksi
include '../function/function.php'; //menyisipkan file function

if (isset($_POST['submit'])) { //proses submit
    $bio = $_POST['bio'];
    
    if($bio != "") { //kondisi jika bio kosong
        $valid = TRUE;
        // !ctype_alnum = inp huruf angka
        // !ctype_alpha = inp huruf
        // !is_numeric = inp angka
        // !filter_var = email

        //update bio
        if ($valid) {

            updateBio($_SESSION['id_register'],$_POST['bio']);
            
        } else { //kembali ke session bio / data bio yang sebelumnya
            $_SESSION['bio'] = $bio;
        }

    } else { //error inputan tidak boleh kosong
        $_SESSION['msg'] = '<p style="color: red;">inputan tidak boleh kosong</p>';
    }            

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bio</title>
    <link rel="stylesheet" href="assets/css/style_edit_bio.css">
</head>
<body>

<!-- form yang prosesnya mengarah ke edit_bio.php -->
    <form action="edit_bio.php" method="POST">
        <textarea name="bio" placeholder="Alamat . . ." cols="30" rows="10"></textarea>
        <?php 
            if (isset($_SESSION['msg'])) { //jika ada seesion msg
                echo $_SESSION['msg']; //maka akan di echo
                unset($_SESSION['msg']); //untuk menghapus session
            }
        ?>
        <br>

        <!-- submit data -->
        <button type="submit" name="submit">Update</button>
        <a href="profile.php">Kembali</a>
    </form>
</body>
</html>