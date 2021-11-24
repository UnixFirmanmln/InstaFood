<?php  
session_start();
if (isset($_SESSION['id_register'])){
    header('location: member/index.php');
}
include 'koneksi.php';
$sql = "SELECT * FROM register";
$stm = $conn->prepare($sql);
$stm->execute();

if (isset($_POST['submit'])) {
    $username_email = $_POST['username_email'];
    $password = $_POST['password'];
    
    if($username_email != "" && $password != "") {

        $sql_login = "SELECT * FROM register WHERE (email = :username_email OR username = :username_email) AND password = SHA2(:password, 0)";
        $stm2 = $conn->prepare($sql_login);
        $stm2->bindValue(':username_email', $_POST['username_email']);
        $stm2->bindValue(':password', $_POST['password']);
        $stm2->execute();
        $row = $stm2->fetch(PDO::FETCH_ASSOC);
            
        if($stm2->rowCount() > 0) {
            if($row['level'] == 'member') {
                
                $_SESSION['id_register'] = $row['id_register'];
                $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
                $_SESSION['umur'] = $row['umur'];
                $_SESSION['jns_kel'] = $row['jns_kel'];
                $_SESSION['alamat'] = $row['alamat'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['password'] = $row['password'];

                $id_register = $_SESSION['id_register'];
                $dataProfil = "SELECT * FROM profil WHERE id_register = '$id_register'";
                $dataProfil = $conn->prepare($dataProfil);
                $dataProfil->execute();
                $row2 = $dataProfil->fetch(PDO::FETCH_ASSOC);
                
                $_SESSION['notelp'] = $row2['notelp'];
                $_SESSION['tempat_lahir'] = $row2['tempat_lahir'];
                $_SESSION['tanggal_lahir'] = $row2['tanggal_lahir'];
                
                header('location: member/index.php');
            }
            else {
                header('location: admin/beranda.php');
            }
        } else {
            echo '<br>
                    <div class="popupbx">
                        <div class="popup">
                            Data yang anda masukkan salah
                        </div>
                    </div>';
        }
            
    } else {
        $_SESSION['msg'] = '<div class="popup2">Data yang anda masukkan kosong</div>';
    }           

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InstaFood Login</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>
<body>
    <div class="center">
        <img src="assets/images/instafood.png">
        <h1></h1>

        <form action="index.php" method="POST">
     
            <?php 
                if(isset($_SESSION['msg'])) {
                    echo "<p style='color:red;'>".$_SESSION['msg']."</p>";
                    unset($_SESSION['msg']);
                } 
            ?> 
    
            <div class="inp_form">   
                <input type="text" name="username_email" placeholder="Username/Email" value="<?php if(isset($_SESSION['username_email'])){echo $_SESSION['username_email']; unset($_SESSION['username_email']);} ?>">
                    <?php
                        if (isset($_SESSION['err_username_email'])) {
                        echo $_SESSION['err_username_email'];
                            unset($_SESSION['err_username_email']);
                        }
                    ?>
                <span></span>
                <label>Username/Email</label>
            </div>
            
            <div class="inp_form">
            <input type="password" name="password" placeholder="Password" value="<?php if(isset($_SESSION['password'])){echo $_SESSION['password']; unset($_SESSION['password']);} ?>">
                <?php
                    if (isset($_SESSION['err_password'])) {
                        echo $_SESSION['err_password'];
                        unset($_SESSION['err_password']);
                }
                ?>
                <span></span>
                <label>Password</label>
            </div>

            <button type="submit" name="submit">Login</button>
            <div class="daftar">
                Belum mempunyai Akun? <a href="member/registrasi.php">Daftar :)</a>
            </div>
        </form>
    </div>
</body>
</html>