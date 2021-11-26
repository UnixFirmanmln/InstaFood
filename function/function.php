<?php 

include '../koneksi.php';

//untuk mendapatkan semua data register
function getRegister(){
    global $conn;

    $query_get_regis = "SELECT * FROM register";
    $ext_get_regis = $conn->prepare($query_get_regis);
    $ext_get_regis->execute();
    return $ext_get_regis;
}

//untuk mendaftarkan member(register)
function registerMember(){
    global $conn;

    $query_regis_member = "INSERT INTO register VALUES(NULL, :nama_lengkap, :umur, :jns_kel, :alamat, :email, :username, SHA2(:password, 0), 'member')";
    $ext_query_regis_member = $conn->prepare($query_regis_member);
    $ext_query_regis_member->bindValue(':nama_lengkap', $_POST['nama_lengkap']);
    $ext_query_regis_member->bindValue(':umur', $_POST['umur']);
    $ext_query_regis_member->bindValue(':jns_kel', $_POST['jns_kel']);
    $ext_query_regis_member->bindValue(':alamat', $_POST['alamat']);
    $ext_query_regis_member->bindValue(':email', $_POST['email']);
    $ext_query_regis_member->bindValue(':username', $_POST['username']);
    $ext_query_regis_member->bindValue(':password', $_POST['password']);

    if($ext_query_regis_member->execute()){
        $_SESSION['msg'] = "Data berhasil disimpan";
    } else {
        $_SESSION['msg'] = "Data gagal disimpan";
    }
}

//untuk mendapatkan id register
function getIdRegister(){
    global $conn;

    $query_getId_regis = "SELECT * FROM register ORDER BY id_register DESC LIMIT 1";
    $ext_getId_regis = $conn->prepare($query_getId_regis);
    $ext_getId_regis->execute();
    return $ext_getId_regis->fetch(PDO::FETCH_ASSOC);
}

//untuk menambahkan data profile
function addDataProfile(){
    global $conn;

    $ext_getId_regis = getIdRegister();
    $sql_insert2 = "INSERT INTO profil VALUES(NULL, :id_register, NULL, NULL, NULL, NULL, NULL)";
    $stm3 = $conn->prepare($sql_insert2);
    $stm3->bindValue(':id_register', $ext_getId_regis['id_register']);

    if($stm3->execute()){
        $_SESSION['msg'] = "Data berhasil disimpan";
    } else {
        $_SESSION['msg'] = "Data gagal disimpan";
    }
}

//untuk menampilkan jumlah postingan
function showCountPosting($id_register){
    global $conn;
    $query_jml_posting = "SELECT COUNT(posting.id_posting) AS jml_posting FROM posting WHERE posting.id_register = $id_register";
    $ext_jml_posting = $conn->prepare($query_jml_posting);
    $ext_jml_posting->execute();
    return $ext_jml_posting->fetch(PDO::FETCH_ASSOC);
}

//untuk menampilkan jumlah pengikut
function showCountFollower($id_register){
    global $conn;
    $query_jml_follower = "SELECT COUNT(followers.id_register) AS jml_follower FROM followers WHERE id_followed = $id_register";
    $ext_jml_follower = $conn->prepare($query_jml_follower);
    $ext_jml_follower->execute();
    return $ext_jml_follower->fetch(PDO::FETCH_ASSOC);
}

//untuk menampilkan jumlah yang diikuti
function showCountFollowing($id_register){
    global $conn;
    $query_jml_following = "SELECT COUNT(followers.id_register) AS jml_following FROM followers WHERE id_register = $id_register";
    $ext_jml_following = $conn->prepare($query_jml_following);
    $ext_jml_following->execute();
    return $ext_jml_following->fetch(PDO::FETCH_ASSOC);
}

//untuk menampilkan postingan yang di follow(diikuti)
function showPostinganFollowing($id_register){
    global $conn;
    $query_postingan_following = "SELECT * FROM posting WHERE id_register IN (SELECT id_followed FROM followers WHERE id_register = $id_register)";
    $ext_postingan_following = $conn->prepare($query_postingan_following);
    $ext_postingan_following->execute();
    return $ext_postingan_following;
}

//untuk memasukkan jumlah data yang di follow
function follow($follower, $following){
    global $conn;

    $follower = $_GET['id_register']; //ngefollow = pengikut
    $following = $_GET['id_followed']; //following = yang akan diikuti

    $query_follow = "INSERT INTO followers VALUES ($follower, $following)";
    $ext_follow = $conn->prepare($query_follow);
    $ext_follow->execute();
    header('location: profile.php?id='.$following);
}

//untuk update bio
function updateBio($id_register, $bio){
    global $conn;
    $query_update_bio = "UPDATE profil SET bio = :bio WHERE id_register = :id_register";
    $ext_update_bio = $conn->prepare($query_update_bio);
    $ext_update_bio->bindValue(':id_register', $id_register);
    $ext_update_bio->bindValue(':bio', $bio);
    if($ext_update_bio->execute()){
        $_SESSION['msg'] = "Data berhasil disimpan";
    } else {
        $_SESSION['msg'] = "Data gagal disimpan";
    }            
}

//untuk update data register
function updateDataRegiser(){
    global $conn;

    $query_update_regis = "UPDATE register SET nama_lengkap = :nama_lengkap,
    umur = :umur, alamat = :alamat, email = :email, username = :username, 
    password = SHA2(:password, 0) WHERE id_register = :id_register";
    $ext_update_regis = $conn->prepare($query_update_regis);
    $ext_update_regis->bindValue(':id_register', $_SESSION['id_register']);
    $ext_update_regis->bindValue(':nama_lengkap', $_POST['nama_lengkap']);
    $ext_update_regis->bindValue(':umur', $_POST['umur']);
    // $ext_update_regis->bindValue(':jns_kel', $_POST['jns_kel']);
    $ext_update_regis->bindValue(':alamat', $_POST['alamat']);
    $ext_update_regis->bindValue(':email', $_POST['email']);
    $ext_update_regis->bindValue(':username', $_POST['username']);
    $ext_update_regis->bindValue(':password', $_POST['password']);
    if($ext_update_regis->execute()){
        $_SESSION['msg'] = "Data berhasil disimpan";
    } else {
        $_SESSION['msg'] = "Data gagal disimpan";
    }
}

//untuk update data profile
function updateDataProfile(){
    global $conn;

    $valid = TRUE;
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

    $query_update_profil = "UPDATE profil SET foto = :foto, notelp = :notelp, tempat_lahir = :tempat_lahir,
    tanggal_lahir = :tanggal_lahir WHERE id_register = :id_register";
    $stm3 = $conn->prepare($query_update_profil);
    $stm3->bindValue(':id_register', $_SESSION['id_register']);
    $stm3->bindValue(':foto', $image);
    $stm3->bindValue(':notelp', $_POST['notelp']);
    $stm3->bindValue(':tempat_lahir', $_POST['tempat_lahir']);
    $stm3->bindValue(':tanggal_lahir', $_POST['tanggal_lahir']);
    if($stm3->execute()){
        $_SESSION['msg'] = "Data berhasil disimpan";
    } else {
        $_SESSION['msg'] = "Data gagal disimpan";
    }
}

//untuk Searching
function searchMember(){
    global $conn;

    $cari =  $_GET['member'];
    $query_search = "SELECT * FROM register WHERE username LIKE '%$cari%'";
    $ext_search = $conn->prepare($query_search);
    $ext_search->execute();
    return $ext_search;
}

//untuk mengambil data tbl followers dan untuk mngurangi jumlah pengkiut jika di unfollow
function getDataTblFollowers($id_register){
    global $conn;

    $query_get_follow = "SELECT * FROM followers WHERE id_register = ".$_SESSION['id_register']." AND id_followed = ".$id_register;
    $ext_unfollow = $conn->prepare($query_get_follow);
    $ext_unfollow->execute();
    return $ext_unfollow;
}

//untuk menghapus data yang di follow
function unfollow(){
    global $conn;

    $follower = $_GET['id_register']; //ngefollow = pengikut
    $following = $_GET['id_followed']; //following = yang akan diikuti

    $query_unfollow = "DELETE FROM followers WHERE id_register = $follower AND id_followed = $following";
    $ext_unfollow = $conn->prepare($query_unfollow);
    $ext_unfollow->execute();
    header('location: profile.php?id='.$following);
}

//untuk mengambil data dari View
function getViewProfile($id_register){
    global $conn;

    $query_getData_viewProfil = "SELECT * FROM view_profil WHERE id_register = $id_register";
    $ext_getData_viewProfil = $conn->query($query_getData_viewProfil);
    $ext_getData_viewProfil->execute();
    $result = $ext_getData_viewProfil->Fetch(PDO::FETCH_ASSOC);
    return $result;
}

//untuk menampilkan postingan
function showPostinganMember($id_register){
    global $conn;

    $query_postingan = "SELECT * FROM posting WHERE id_register = $id_register";
    $ext_postingan = $conn->prepare($query_postingan);
    $ext_postingan->execute();
    return $ext_postingan;
}
?>