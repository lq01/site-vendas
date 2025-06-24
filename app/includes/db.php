<?php
$host = 'localhost';
$user = 'root';
$pass = 'luique1810';
$dbname = 'mydb';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>