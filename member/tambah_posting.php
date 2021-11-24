<?php  
session_start();
include '../koneksi.php';
$sql = "SELECT * FROM posting";
$stm = $conn->prepare($sql);
$stm->execute();

if (isset($_POST['submit'])) {
   
    $pesan = $_POST['pesan'];
   
    if($pesan != "") {
        $valid = TRUE;
        // !ctype_alnum = inp huruf angka
        // !ctype_alpha = inp huruf
        // !is_numeric = inp angka
        // !filter_var = email

        // Validasi Gambar
        $image = "";
        if($_FILES["gambar"]["size"] == 0){
            $image = "";
            $valid++;
            $errimg = "";
        } elseif( !getimagesize($_FILES["gambar"]["tmp_name"]) ){
            $errimg = "data yang diupload harus berupa gambar";
        } else {
            $image = file_get_contents($_FILES["gambar"]["tmp_name"]);
            $valid++;
            $errimg = "";
        }

        if ($valid) {
            
            $sql_insert = "INSERT INTO posting(id_register, gambar, pesan) VALUES(:id_register, :gambar, :pesan)";
            $stm2 = $conn->prepare($sql_insert);
            $stm2->bindValue(':id_register', $_SESSION['id_register']);
            $stm2->bindValue(':gambar', $image);
            $stm2->bindValue(':pesan', $_POST['pesan']);
            $msg = '';
            if($stm2->execute()){
                $msg .= '
                <div class="popupbx">
                    <div class="popup">
                        Posting telah berhasil disimpan
                    </div>
                </div>';
            } 
            else {
                $msg .= '<br>
                    <div class="popupbox">
                        <div class="popupx">
                            Data yang anda masukkan salah
                        </div>
                    </div>';
            }

        } else {
            $_SESSION['gambar'] = $gambar;
            $_SESSION['pesan'] = $pesan;
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
    <title>Tambah Posting</title>
    <link rel="stylesheet" href="assets/css/style_tambah_posting.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <?= isset($msg) ? $msg : '' ?>
    <div class="center">
        <form action="tambah_posting.php" method="POST" enctype="multipart/form-data">
            <h3>Upload Image</h3>
            <input type="file" name="gambar">
            <br>
            <br>
            <br>

            <h3>Pesan</h3>
            <textarea name="pesan" placeholder="pesan . . ."></textarea>

            <div class="btn">
                <div class="btn_back">
                    <a href="profile.php"><h6>Kembali</h6></a>
                </div>
                <button type="submit" name="submit">Upload</button>
            </div>
            
            
            
        </form>
    </div>
    
</body>
</html>