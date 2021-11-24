<?php 

include '../koneksi.php';

//untuk mengambil data yang akan di follow sama data follower
$follower = $_GET['id_register']; //ngefollow = pengikut
$following = $_GET['id_followed']; //following = yang akan diikuti

$query_unfollow = "DELETE FROM followers WHERE id_register = $follower AND id_followed = $following";
$ext_unfollow = $conn->prepare($query_unfollow);
$ext_unfollow->execute();
header('location: profile.php?id='.$following);

?>