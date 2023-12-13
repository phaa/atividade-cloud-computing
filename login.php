<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "config.php";

if (isset($_POST['but_submit'])) {

    $login = mysqli_real_escape_string($con, $_POST['txt_login']);
    $password = mysqli_real_escape_string($con, $_POST['txt_senha']);

    if ($login != "" && $password != "") {

        // query simples
        $sql_query = "select count(*) as existeUsuario from users where login='{$login}' and senha='{$password}'";
        $result = mysqli_query($con, $sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['existeUsuario'];

        if ($count > 0) {
            $_SESSION['login'] = $login;
            header('Location: dashboard.php');
        } else {
            echo "Credenciais inválidas";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    /* Container */
    .container {
      width: 40%;
      margin: 0 auto;
    }

    /* Login */
    #div_login {
      border: 1px solid gray;
      border-radius: 3px;
      width: 470px;
      height: 270px;
      box-shadow: 0px 2px 2px 0px gray;
      margin: 0 auto;
    }

    #div_login h1 {
      margin-top: 0px;
      font-weight: normal;
      padding: 10px;
      background-color: cornflowerblue;
      color: white;
      font-family: sans-serif;
    }

    #div_login div {
      clear: both;
      margin-top: 10px;
      padding: 5px;
    }

    #div_login .textbox {
      width: 96%;
      padding: 7px;
    }

    #div_login input[type=submit] {
      padding: 7px;
      width: 100px;
      background-color: lightseagreen;
      border: 0px;
      color: white;
    }
  </style>
</head>

<body>
  <div class="container">
    <form method="post" action="">
      <div id="div_login">
        <h1>Login</h1>
        <div>
          <input type="text" class="textbox" id="txt_login" name="txt_login" placeholder="Login" />
        </div>
        <div>
          <input type="password" class="textbox" id="txt_senha" name="txt_senha" placeholder="Senha" />
        </div>
        <div>
          <input type="submit" value="Login" name="but_submit" id="but_submit" />
        </div>
      </div>
    </form>
  </div>
</body>

</html>