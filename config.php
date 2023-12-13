<?php
session_start();
$host = "localhost";
$usuario = "usuario";
$senha = "password";

try {
  $conn = new PDO("mysql:host=$host;dbname=meusistema", $usuario, $senha);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Conectado com sucesso";
} catch(PDOException $e) {
  echo "Falha na conexão: " . $e->getMessage();
}
