<?php 

include '../koneksi.php';

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

//untuk menampilkan jumlah pengikut
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

?>