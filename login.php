<?php  

// memulai session
session_start();

// kondisi jika ada session id_register maka akan dirahkan ke index member
if (isset($_SESSION['id_register'])){
    header('location: member/index.php');
}

// menyisipkan file koneksi.php
include 'koneksi.php';

//mengambil semua data pada tabel register
$sql = "SELECT * FROM register";
$stm = $conn->prepare($sql);
$stm->execute();

//kondisi jika actor menekan tombol Login
if (isset($_POST['submit'])) {
    $username_email = $_POST['username_email'];
    $password = $_POST['password'];
    
    //kondisi jika username, email tidak kosong dan password tidak kosong
    if($username_email != "" && $password != "") {
        $sql_login = "SELECT * FROM register WHERE (email = :username_email OR username = :username_email) AND password = SHA2(:password, 0)";
        $stm2 = $conn->prepare($sql_login);
        $stm2->bindValue(':username_email', $_POST['username_email']);
        $stm2->bindValue(':password', $_POST['password']);
        $stm2->execute();
        $row = $stm2->fetch(PDO::FETCH_ASSOC);
        
        //jika jumlah baris data > 0
        if($stm2->rowCount() > 0) {

            //jika level member maka data-data session di bawah akan ikut digunakan setelah login
            if($row['level'] == 'member') {
                $_SESSION['level'] = $row['level']; //session level member

                $_SESSION['id_register'] = $row['id_register'];
                $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
                $_SESSION['umur'] = $row['umur'];
                $_SESSION['jns_kel'] = $row['jns_kel'];
                $_SESSION['alamat'] = $row['alamat'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['password'] = $row['password'];

                //membawa data-data sesion pada tabel profil
                $id_register = $_SESSION['id_register'];
                $dataProfil = "SELECT * FROM profil WHERE id_register = '$id_register'";
                $dataProfil = $conn->prepare($dataProfil);
                $dataProfil->execute();
                $row2 = $dataProfil->fetch(PDO::FETCH_ASSOC);
                
                $_SESSION['notelp'] = $row2['notelp'];
                $_SESSION['tempat_lahir'] = $row2['tempat_lahir'];
                $_SESSION['tanggal_lahir'] = $row2['tanggal_lahir'];
                
                header('location: member/index.php'); //jika level member maka akan dirahkan ke index member
            }
            else { //jika level bukan member (maka level admin)
                //membawa data-data session yang diperlukan untuk admin
                $_SESSION['level'] = $row['level']; ////session level admin

                $_SESSION['id_register'] = $row['id_register'];
                $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
                $_SESSION['umur'] = $row['umur'];
                $_SESSION['jns_kel'] = $row['jns_kel'];
                $_SESSION['alamat'] = $row['alamat'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['password'] = $row['password'];
                $_SESSION['foto'] = $row['foto'];
                
                //membawa data-data sesion pada tabel profil
                $id_register = $_SESSION['id_register'];
                $dataProfil = "SELECT * FROM profil WHERE id_register = '$id_register'";
                $dataProfil = $conn->prepare($dataProfil);
                $dataProfil->execute();
                $row2 = $dataProfil->fetch(PDO::FETCH_ASSOC);
                
                $_SESSION['notelp'] = $row2['notelp'];
                $_SESSION['tempat_lahir'] = $row2['tempat_lahir'];
                $_SESSION['tanggal_lahir'] = $row2['tanggal_lahir'];
                $_SESSION['bio'] = $row2['bio'];
                
                header('location: admin/index.php'); //jika level admin maka akan dirahkan ke index admin
            }
        } else { //jika data yang diinput tidak benar maka akan muncul Popup
            echo '<br>
                    <div class="popupbx">
                        <div class="popup">
                            Data yang anda masukkan salah
                        </div>
                    </div>';
        }
            
    } else { //jika data yang diinput kosong
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
    <link rel="stylesheet" type="text/css" href="assets/css/login.css">

</head>
<body>
    
    <!-- untuk memberikan posisi pada tengah -->
    <div class="center">
        <img src="assets/images/instafood.png">
        <h1></h1>

        <!-- form yang prosesnya mengarah pada login.php -->
        <form action="login.php" method="POST">

            <!-- sebagai pesan error -->
            <?php 
                if(isset($_SESSION['msg'])) {
                    echo "<p style='color:red;'>".$_SESSION['msg']."</p>";
                    unset($_SESSION['msg']);
                } 
            ?> 

            <!-- input form username atau email -->
            <div class="inp_form">   
                <input type="text" name="username_email" placeholder="Username/Email" value="<?php if(isset($_SESSION['username_email'])){echo $_SESSION['username_email']; unset($_SESSION['username_email']);} ?>">
                    <?php
                        if (isset($_SESSION['err_username_email'])) { //jika ada seesion err_username_email
                        echo $_SESSION['err_username_email']; //maka akan di echo
                            unset($_SESSION['err_username_email']); //untuk menghapus session
                        }
                    ?>
                <span></span> <!-- Sebagai animasi jika user mengclick kolom input -->
                <label>Username/Email</label> <!-- label username/email -->
            </div>
            
            <!-- input form password -->
            <div class="inp_form">
            <input type="password" name="password" placeholder="Password" value="<?php if(isset($_SESSION['password'])){echo $_SESSION['password']; unset($_SESSION['password']);} ?>">
                <?php
                    if (isset($_SESSION['err_password'])) { //jika ada seesion err_password
                        echo $_SESSION['err_password']; //maka akan di echo
                        unset($_SESSION['err_password']); //untuk menghapus session
                }
                ?>
                <span></span> <!-- Sebagai animasi jika user mengclick kolom input -->
                <label>Password</label> <!-- label username/email -->
            </div>
            
            <!-- proses submit -->
            <button type="submit" name="submit">Login</button>

            <!-- pendaftaran -->
            <div class="daftar">
                Belum mempunyai Akun? <a href="member/registrasi.php">Daftar :)</a>
            </div>
        </form>
    </div>
</body>
</html>