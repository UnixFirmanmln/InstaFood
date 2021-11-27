<?php  
session_start(); //memulai session
include '../koneksi.php'; //menyisipkan file koneksi
include '../function/function.php'; //menyisipkan file function

if (isset($_POST['submit'])) { //proses submit
    $nama_lengkap = $_POST['nama_lengkap'];
    $umur = $_POST['umur'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    //inputan tidak boleh kosong
    if($nama_lengkap != "" && $umur != "" && $alamat != "" && $email != "" && $username != "" && $password != "") {
        $valid = TRUE;
        // !ctype_alnum = inp huruf angka
        // !ctype_alpha = inp huruf
        // !is_numeric = inp angka
        // !filter_var = email

        // validasi
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

        if ($valid) { //jika benar maka diupdate
            
            updateDataRegiser(); //update data tabel regis
            updateDataProfile(); //update data table profile         

        } else {
            $_SESSION['nama_lengkap'] = $nama_lengkap;
            $_SESSION['umur'] = $umur;
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
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style_edit_profile.css">
		
	</style>
</head>
<body>
    <div class="center">
        <img src="">
        <h1>Edit Profil</h1>

        <!-- form yang prosesnya mengarah ke edit_profile.php -->
        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
           
        <!-- sebagai pesan error -->
            <?php 
                if(isset($_SESSION['msg'])) {
                    echo "<p style='color:red;'>".$_SESSION['msg']."</p>";
                    unset($_SESSION['msg']);
                } 
            ?>

         <!-- input form foto-->
        <div class="inp_form">
            <label>foto</label>
            <input type="file" accept="image/*" name="foto" value="<?php if(isset($_SESSION['foto'])){echo $_SESSION['foto']; unset($_SESSION['foto']);} ?>">
                <?php
                    if (isset($_SESSION['err_foto'])) {
                        echo $_SESSION['err_foto'];
                        unset($_SESSION['err_foto']);
                    }
                ?>
        </div>
        
        <!-- input form nama lengkap-->
        <div class="inp_form"><br>
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" value="<?php echo $_SESSION['nama_lengkap']; ?>">
                <?php
                    if (isset($_SESSION['err_nama_lengkap'])) {
                        echo $_SESSION['err_nama_lengkap'];
                        unset($_SESSION['err_nama_lengkap']);
                    }
                ?>    
        </div>

        <!-- input form umur  -->
        <div class="inp_form"><br>
            <label>Umur</label>
            <input type="text" name="umur" placeholder="Umur" value="<?php echo $_SESSION['umur']; ?>">
                <?php
                    if (isset($_SESSION['err_umur'])) {
                        echo $_SESSION['err_umur'];
                        unset($_SESSION['err_umur']);
                    }
                ?>
        </div>
                            
         <!-- input form alamat -->             
        <div class="inp_form"><br>
            <label>Alamat</label>
            <input type="text" name="alamat" placeholder="Alamat" value="<?php echo $_SESSION['alamat']; ?>">
                <?php
                    if (isset($_SESSION['err_alamat'])) {
                        echo $_SESSION['err_alamat'];
                        unset($_SESSION['err_alamat']);
                    }
                ?> 
            <span></span>
        </div>

        <!-- input form no telp-->
        <div class="inp_form"><br>
            <label>No Telepon</label>
            <input type="text" name="notelp" placeholder="No Telepon" value="<?php echo $_SESSION['notelp']; ?>">
                <?php
                    if (isset($_SESSION['Err_notelp'])) {
                        echo $_SESSION['Err_notelp'];
                        unset($_SESSION['Err_notelp']);
                    }
                ?>
            <span></span>   
        </div>

        <!-- input form  tempat lahir-->
        <div class="inp_form"><br>
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" placeholder="Tempat Lahir" value="<?php echo $_SESSION['tempat_lahir']; ?>">
                <?php
                    if (isset($_SESSION['Err_tempat_lahir'])) {
                        echo $_SESSION['Err_tempat_lahir'];
                        unset($_SESSION['Err_tempat_lahir']);
                    }
                ?>
            <span></span>
        </div>

        <!-- input form tanggal lahir -->
        <div class="inp_form"><br>
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" placeholder="Tanggal Lahir" value="<?php echo $_SESSION['tanggal_lahir']; ?>">
                <?php
                    if (isset($_SESSION['Err_tanggal_lahirr'])) {
                        echo $_SESSION['Err_tanggal_lahir'];
                        unset($_SESSION['Err_tanggal_lahir']);
                    }
                ?>
            <span></span>
        </div>

        <!-- input form email -->
        <div class="inp_form"><br>
            <label>Email</label>
            <input type="text" name="email" placeholder="Email" value="<?php echo $_SESSION['email']; ?>">
                <?php
                    if (isset($_SESSION['err_email'])) {
                        echo $_SESSION['err_email'];
                        unset($_SESSION['err_email']);
                    }
                ?>
            <span></span>
        </div>

         <!-- input form username -->
        <div class="inp_form"><br>
            <label>Username</label>
            <input type="text" name="username" placeholder="Username" value="<?php echo $_SESSION['username']; ?>">
                <?php
                    if (isset($_SESSION['err_username'])) {
                        echo $_SESSION['err_username'];
                        unset($_SESSION['err_username']);
                    }
                ?>
            <span></span>
        </div>

        <!-- input form password -->
        <div class="inp_form"><br>
            <label>Password</label>
            <input type="password" name="password" placeholder="Password">
                <?php
                    if (isset($_SESSION['err_password'])) {
                        echo $_SESSION['err_password'];
                        unset($_SESSION['err_password']);
                    }
                ?>
            <span></span>
        </div>
                
        <!-- button simpan -->
        <button type="submit" name="submit">Simpan</button>
        <a href="profile.php">Kembali</a>
                     
        </form>
    </div>
</body>
</html>