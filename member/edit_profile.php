<?php  
session_start();
include '../koneksi.php';
// $id_register = $_SESSION['id_register'];
// $sql = "SELECT * FROM register WHERE id_register = '$id_register'";
// $stm = $conn->prepare($sql);
// $stm->execute();

if (isset($_POST['submit'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $umur = $_POST['umur'];
    $jns_kel = $_POST['jns_kel'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if($nama_lengkap != "" && $umur != "" && $jns_kel != "" && $alamat != "" && $email != "" && $username != "" && $password != "") {
        $valid = TRUE;
        // !ctype_alnum = inp huruf angka
        // !ctype_alpha = inp huruf
        // !is_numeric = inp angka
        // !filter_var = email

        $_SESSION['jns_kel'] = $jns_kel;

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

        $image = "";
        if($_FILES["foto"]["size"] == 0){
            $image = "";
            $valid++;
            $errimg = "";
        } elseif( !getimagesize($_FILES["foto"]["tmp_name"]) ){
            $errimg = "data yang diupload harus berupa gambar";
        } else {
            $image = file_get_contents($_FILES["foto"]["tmp_name"]);
            $valid++;
            $errimg = "";
        }

        if ($valid) {
            $sql_update_regis = "UPDATE register SET nama_lengkap = :nama_lengkap,
            umur = :umur, jns_kel = :jns_kel, alamat = :alamat, email = :email, username = :username, 
            password = SHA2(:password, 0) WHERE id_register = :id_register";
            $stm2 = $conn->prepare($sql_update_regis);
            $stm2->bindValue(':id_register', $_SESSION['id_register']);
            $stm2->bindValue(':nama_lengkap', $_POST['nama_lengkap']);
            $stm2->bindValue(':umur', $_POST['umur']);
            $stm2->bindValue(':jns_kel', $_POST['jns_kel']);
            $stm2->bindValue(':alamat', $_POST['alamat']);
            $stm2->bindValue(':email', $_POST['email']);
            $stm2->bindValue(':username', $_POST['username']);
            $stm2->bindValue(':password', $_POST['password']);
            if($stm2->execute()){
                $_SESSION['msg'] = "Data berhasil disimpan";
            } else {
                $_SESSION['msg'] = "Data gagal disimpan";
            }

            $sql_update_profil = "UPDATE profil SET foto = :foto, notelp = :notelp, tempat_lahir = :tempat_lahir,
            tanggal_lahir = :tanggal_lahir WHERE id_register = :id_register";
            $stm3 = $conn->prepare($sql_update_profil);
            $stm3->bindValue(':id_register', $_SESSION['id_register']);
            $stm3->bindValue(':foto', $image);
            $stm3->bindValue(':notelp', $_POST['notelp']);
            $stm3->bindValue(':tempat_lahir', $_POST['tempat_lahir']);
            $stm3->bindValue(':tanggal_lahir', $_POST['tanggal_lahir']);
            // $stm3->bindValue(':bio', $_POST['bio']);
            if($stm3->execute()){
                $_SESSION['msg'] = "Data berhasil disimpan";
            } else {
                $_SESSION['msg'] = "Data gagal disimpan";
            }


            

        } else {
            $_SESSION['nama_lengkap'] = $nama_lengkap;
            $_SESSION['umur'] = $umur;
            $_SESSION['jns_kel'] = $jns_kel;
            $_SESSION['alamat'] = $alamat;
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
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
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style_edit_profile.css">
		
	</style>
</head>
<body>
    <div class="center">
        <img src="">
        <h1>Edit Profil</h1>

        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
           
            <?php 
                if(isset($_SESSION['msg'])) {
                    echo "<p style='color:red;'>".$_SESSION['msg']."</p>";
                    unset($_SESSION['msg']);
                } 
            ?>

        
        <div class="inp_form">
            <input type="file" accept="image/*" name="foto" value="<?php if(isset($_SESSION['foto'])){echo $_SESSION['foto']; unset($_SESSION['foto']);} ?>">
                <?php
                    if (isset($_SESSION['err_foto'])) {
                        echo $_SESSION['err_foto'];
                        unset($_SESSION['err_foto']);
                    }
                ?>
            <span></span>
            <label>foto</label>
        </div>
        
        <div class="inp_form">
            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" value="<?php echo $_SESSION['nama_lengkap']; ?>">
                <?php
                    if (isset($_SESSION['err_nama_lengkap'])) {
                        echo $_SESSION['err_nama_lengkap'];
                        unset($_SESSION['err_nama_lengkap']);
                    }
                ?>
            <span></span>
            <label>Nama Lengkap</label>
        </div>


        <div class="inp_form">
            <input type="text" name="umur" placeholder="Umur" value="<?php echo $_SESSION['umur']; ?>">
                <?php
                    if (isset($_SESSION['err_umur'])) {
                        echo $_SESSION['err_umur'];
                        unset($_SESSION['err_umur']);
                    }
                ?>
            <span></span>
            <label>Umur</label>
        </div>
                            
                        
        <div class="inp_form">
            <input type="text" name="alamat" placeholder="Alamat" value="<?php echo $_SESSION['alamat']; ?>">
                <?php
                    if (isset($_SESSION['err_alamat'])) {
                        echo $_SESSION['err_alamat'];
                        unset($_SESSION['err_alamat']);
                    }
                ?> 
            <span></span>
            <label>Alamat</label>
        </div>

        <div class="inp_form">
            <input type="text" name="notelp" placeholder="No Telepon" value="<?php echo $_SESSION['notelp']; ?>">
                <?php
                    if (isset($_SESSION['Err_notelp'])) {
                        echo $_SESSION['Err_notelp'];
                        unset($_SESSION['Err_notelp']);
                    }
                ?>
            <span></span>
            <label>No Telepon</label>
        </div>

        <div class="inp_form">
            <input type="text" name="tempat_lahir" placeholder="Tempat Lahir" value="<?php echo $_SESSION['tempat_lahir']; ?>">
                <?php
                    if (isset($_SESSION['Err_tempat_lahir'])) {
                        echo $_SESSION['Err_tempat_lahir'];
                        unset($_SESSION['Err_tempat_lahir']);
                    }
                ?>
            <span></span>
            <label>Tempat Lahir</label>
        </div>

        <div class="inp_form">
            <input type="date" name="tanggal_lahir" placeholder="Tanggal Lahir" value="<?php echo $_SESSION['tanggal_lahir']; ?>">
                <?php
                    if (isset($_SESSION['Err_tanggal_lahirr'])) {
                        echo $_SESSION['Err_tanggal_lahir'];
                        unset($_SESSION['Err_tanggal_lahir']);
                    }
                ?>
            <span></span>
            <label>Tanggal Lahir</label>
        </div>



        <div class="inp_form">
            <input type="text" name="email" placeholder="Email" value="<?php echo $_SESSION['email']; ?>">
                <?php
                    if (isset($_SESSION['err_email'])) {
                        echo $_SESSION['err_email'];
                        unset($_SESSION['err_email']);
                    }
                ?>
            <span></span>
            <label>Email</label>
        </div>


        <div class="inp_form">
            <input type="text" name="username" placeholder="Username" value="<?php echo $_SESSION['username']; ?>">
                <?php
                    if (isset($_SESSION['err_username'])) {
                        echo $_SESSION['err_username'];
                        unset($_SESSION['err_username']);
                    }
                ?>
            <span></span>
            <label>Username</label>
        </div>


        <div class="inp_form">
            <input type="password" name="password" placeholder="Password">
                <?php
                    if (isset($_SESSION['err_password'])) {
                        echo $_SESSION['err_password'];
                        unset($_SESSION['err_password']);
                    }
                ?>
            <span></span>
            <label>Password</label>
        </div>
                
        <button type="submit" name="submit">Simpan</button>
        <a href="profile.php">Kembali</a>
                     
        </form>
    </div>
</body>
</html>