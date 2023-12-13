<?php
session_start();
$host = "localhost";
$usuario = "root";
$senha = "";
$db = "meusistema";

$con = mysqli_connect($host, $usuario, $senha, $db);

if (!$con) {
  die("Falha na conexão: " . mysqli_connect_error());
}
