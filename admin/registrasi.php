<?php  
session_start(); //memulai session
include '../koneksi.php'; //menyisipkan file koneksi
include '../function/function.php'; //menyisipkan file function

//proses submit
if (isset($_POST['submit'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $umur = $_POST['umur'];
    $jns_kel = $_POST['jns_kel'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // jika data-data dari form input tidak kosong
    if($nama_lengkap != "" && $umur != "" && $jns_kel != "" && $alamat != "" && $email != "" && $username != "" && $password != "") {
        $valid = TRUE;
        // !ctype_alnum = inp huruf angka
        // !ctype_alpha = inp huruf
        // !is_numeric = inp angka
        // !filter_var = email

        $_SESSION['jns_kel'] = $jns_kel;

        //validasi
        if(!is_numeric($_POST['umur'])) {
            $_SESSION['err_umur'] = 'Inputan harus berupa angka';
            $valid = FALSE;
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['err_email'] = 'Inputan harus berupa email';
            $valid = FALSE;
        }

        if(!ctype_alnum($_POST['username'])) {
            $_SESSION['err_username'] = 'inputan harus berupa huruf / angka';
            $valid = FALSE;
        } 

        if(strlen($_POST['password']) < 8) {
            $_SESSION['err_password'] = 'Masukkan password minimal 8 karakter';
            $valid = FALSE;
        }

        if ($valid) { //jika data benar maka data akan di update

            //update data dari table register level admin
            registerAdmin();

            //mengambil id register
            getIdRegister();

            //update data dari tabel profil
            addDataProfile();

        } else {
            $_SESSION['nama_lengkap'] = $nama_lengkap;
            $_SESSION['umur'] = $umur;
            $_SESSION['jns_kel'] = $jns_kel;
            $_SESSION['alamat'] = $alamat;
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
        }

    } else { //pesan error
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
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style_registrasi.css">
		
	</style>
</head>
<body>
<div class="center">
        <img src="">
        <h1>Registrasi</h1>

        <!-- form yang prosesnya mengarah pada registrasi.php -->
        <form action="registrasi.php" method="POST">
           
        <!-- sebagai pesan error -->
            <?php 
                if(isset($_SESSION['msg'])) {
                    echo "<p style='color:red;'>".$_SESSION['msg']."</p>";
                    unset($_SESSION['msg']);
                } 
            ?>

        <!-- input form nama lengkap -->
        <div class="left">
            <div class="inp_form">
                <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" value="<?php if(isset($_SESSION['nama_lengkap'])){echo $_SESSION['nama_lengkap']; unset($_SESSION['nama_lengkap']);} ?>">
                    <?php
                        if (isset($_SESSION['err_nama_lengkap'])) {
                            echo $_SESSION['err_nama_lengkap'];
                            unset($_SESSION['err_nama_lengkap']);
                        }
                    ?>
                <span></span>
                <label>Nama Lengkap</label>
            </div>

            <!-- input form umur-->
            <div class="inp_form">
                <input type="text" name="umur" placeholder="Umur" value="<?php if(isset($_SESSION['umur'])){echo $_SESSION['umur']; unset($_SESSION['umur']);} ?>">
                    <?php
                        if (isset($_SESSION['err_umur'])) {
                            echo $_SESSION['err_umur'];
                            unset($_SESSION['err_umur']);
                        }
                    ?>
                <span></span>
                <label>Umur</label>
            </div>
                            
            <!-- input form jenis kelamin-->
            <div class="inp_form">
                <h4>Jenis kelamin</h4>                        
                <input type="radio" name="jns_kel" value="pria" 
                    <?php 
                        if (isset($_SESSION['jns_kel']) && $_SESSION['jns_kel'] == 'pria'){
                            echo "checked"; 
                            unset($_SESSION['jns_kel']);
                        }
                    ?>
                > <div class="radio_pria">Pria</div> 
                
                <div class="right_radio_w">
                    <input type="radio" name="jns_kel" value="wanita"
                        <?php 
                            if (isset($_SESSION['jns_kel']) && $_SESSION['jns_kel'] == 'wanita'){
                                echo "checked"; 
                                unset($_SESSION['jns_kel']);
                            } 
                        ?>
                    > <div class="radio_wanita">Wanita</div>
                </div> 
            </div>
                                
            <!-- input form alamat-->   
            <div class="inp_form">
                <input type="text" name="alamat" placeholder="Alamat" value="<?php if(isset($_SESSION['alamat'])){echo $_SESSION['alamat']; unset($_SESSION['alamat']);} ?>">
                    <?php
                        if (isset($_SESSION['err_alamat'])) {
                            echo $_SESSION['err_alamat'];
                            unset($_SESSION['err_alamat']);
                        }
                    ?>
                <span></span>
                <label>Alamat</label>
            </div>
        </div>

        <!-- input form email-->
        <div class="right">
            <div class="inp_form">
                <input type="text" name="email" placeholder="Email" value="<?php if(isset($_SESSION['email'])){echo $_SESSION['email']; unset($_SESSION['email']);} ?>">
                    <?php
                        if (isset($_SESSION['err_email'])) {
                            echo $_SESSION['err_email'];
                            unset($_SESSION['err_email']);
                        }
                    ?>
                <span></span>
                <label>Email</label>
            </div>

            <!-- input form username-->
            <div class="inp_form">
                <input type="text" name="username" placeholder="Username" value="<?php if(isset($_SESSION['username'])){echo $_SESSION['username']; unset($_SESSION['username']);} ?>">
                    <?php
                        if (isset($_SESSION['err_username'])) {
                            echo $_SESSION['err_username'];
                            unset($_SESSION['err_username']);
                        }
                    ?>
                <span></span>
                <label>Username</label>
            </div>

            <!-- input form password-->
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
        </div>
        
        <!-- button submit -->
        <button type="submit" name="submit">Submit</button>
        <div class="login">
            Sudah mempunyai Akun? <a href="../index.php">Login :)</a>
        </div>
                     
        </form>
    </div>
</body>
</html>