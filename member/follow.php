<?php 
// function follow($follower, $following){
//     global $conn;
//     $query_follow = "INSERT INTO followers VALUES ($follower, $following)";
//     $ext_follow = $conn->prepare($query_follow);
//     $ext_follow->execute();

//     header('location: profile.php?id='.$following);
// }
include '../koneksi.php';

//untuk mengambil data yang akan di follow sama data follower
$follower = $_GET['id_register']; //ngefollow = pengikut
$following = $_GET['id_followed']; //following = yang akan diikuti

$query_follow = "INSERT INTO followers VALUES ($follower, $following)";
$ext_follow = $conn->prepare($query_follow);
$ext_follow->execute();
header('location: profile.php?id='.$following);

?>