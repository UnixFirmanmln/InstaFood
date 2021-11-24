<?php  
session_start();
include '../koneksi.php';
$sql = "SELECT * FROM register";
$stm = $conn->prepare($sql);
$stm->execute();

if (isset($_POST['submit'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $umur = $_POST['umur'];
    $jns_kel = isset($_POST['jns_kel']) ? $_POST['jns_kel'] : ""; //untuk menghilangkan error jika jns kel tidak diisi
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

        if ($valid) {

            $sql_insert = "INSERT INTO register VALUES(NULL, :nama_lengkap, :umur, :jns_kel, :alamat, :email, :username, SHA2(:password, 0), 'member')";
            $stm2 = $conn->prepare($sql_insert);
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

            $getId_regis = "SELECT * FROM register ORDER BY id_register DESC LIMIT 1";
            $getId_regis = $conn->prepare($getId_regis);
            $getId_regis->execute();
            $ext = $getId_regis->fetch(PDO::FETCH_ASSOC);
            $sql_insert2 = "INSERT INTO profil VALUES(NULL, :id_register, NULL, NULL, NULL, NULL, NULL)";
            $stm3 = $conn->prepare($sql_insert2);
            $stm3->bindValue(':id_register', $ext['id_register']);

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
    <title>Member</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style_registrasi.css">
		
</head>
<body>
    <div class="center">
        <img src="">
        <h1>Registrasi</h1>

        <form action="registrasi.php" method="POST">
           
            <?php 
                if(isset($_SESSION['msg'])) {
                    echo "<p style='color:red;'>".$_SESSION['msg']."</p>";
                    unset($_SESSION['msg']);
                } 
            ?>
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
                
        <button type="submit" name="submit">Submit</button>
        <div class="login">
            Sudah mempunyai Akun? <a href="../index.php">Login :)</a>
        </div>
                     
        </form>
    </div>
</body>
</html>