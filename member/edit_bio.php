<?php 

session_start();
include '../koneksi.php';
include '../function/function.php';

if (isset($_POST['submit'])) {
    $bio = $_POST['bio'];
    
    if($bio != "") {
        $valid = TRUE;
        // !ctype_alnum = inp huruf angka
        // !ctype_alpha = inp huruf
        // !is_numeric = inp angka
        // !filter_var = email

        if ($valid) {

            updateBio($_SESSION['id_register'],$_POST['bio']);
            
        } else {
            $_SESSION['bio'] = $bio;
        }

    } else {
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
    <form action="edit_bio.php" method="POST">
        <textarea name="bio" placeholder="Alamat . . ." cols="30" rows="10"></textarea>
        <?php 
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
        ?>
        <br>

        <button type="submit" name="submit">Update</button>
        <a href="profile.php">Kembali</a>
    </form>
</body>
</html>