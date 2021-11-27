<?php  
$servername = "localhost"; //nama server
$username = "root"; //username
$password = ""; //password
$database = "instafood"; //database name

// variabel koneksi yang dipakai
$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

?>
