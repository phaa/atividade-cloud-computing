<?php
// Inicialize a sessão
session_start();

// Verifique se o usuário já está logado, em caso afirmativo, redirecione-o para a página de boas-vindas
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	header("location: dashboard.php");
	exit;
}

// Incluir arquivo de configuração
require_once "config.php";

// Defina variáveis e inicialize com valores vazios
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processando dados do formulário quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Verifique se o nome de usuário está vazio
	if (empty(trim($_POST["username"]))) {
		$username_err = "Por favor, insira o nome de usuário.";
	} else {
		$username = trim($_POST["username"]);
	}

	// Verifique se a senha está vazia
	if (empty(trim($_POST["password"]))) {
		$password_err = "Por favor, insira sua senha.";
	} else {
		$password = trim($_POST["password"]);
	}

	// Validar credenciais
	if (empty($username_err) && empty($password_err)) {
		// Prepare uma declaração selecionada
		$sql = "SELECT idusuario, login, senha FROM users WHERE login = :login";

		if ($stmt = $pdo->prepare($sql)) {
			// Definir parâmetros
			$param_username = trim($_POST["username"]);

			$stmt->bindParam(":login", $param_username, PDO::PARAM_STR);

			// Tente executar a declaração preparada
			if ($stmt->execute()) {
				// Verifique se o nome de usuário existe, se sim, verifique a senha
				if ($stmt->rowCount() == 1) {
					if ($row = $stmt->fetch()) {
						$id = $row["idusuario"];
						$username = $row["login"];
						$db_password = $row["senha"];
						if ($password == $db_password) {
							// A senha está correta, então inicie uma nova sessão
							session_start();

							// Armazene dados em variáveis de sessão
							$_SESSION["loggedin"] = true;
							$_SESSION["id"] = $id;
							$_SESSION["username"] = $username;

							// Redirecionar o usuário para a página de boas-vindas
							header("location: dashboard.php");
						} else {
							// A senha não é válida, exibe uma mensagem de erro genérica
							$login_err = "Nome de usuário ou senha inválidos.";
						}
					}
				} else {
					// O nome de usuário não existe, exibe uma mensagem de erro genérica
					$login_err = "Nome de usuário ou senha inválidos.";
				}
			} else {
				echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
			}
			// Fechar declaração
			unset($stmt);
		}
	}

	// Fechar conexão
	unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<title>Cadastro</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		body {
			font: 14px sans-serif;
		}

		.wrapper {
			width: 360px;
			padding: 20px;
		}
	</style>
</head>

<body>
	<div class="wrapper">
		<h2>Cadastro</h2>
		<p>Por favor, preencha este formulário para criar uma conta.</p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="form-group">
				<label>Nome do usuário</label>
				<input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
				<span class="invalid-feedback"><?php echo $username_err; ?></span>
			</div>
			<div class="form-group">
				<label>Senha</label>
				<input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
				<span class="invalid-feedback"><?php echo $password_err; ?></span>
			</div>
			<div class="form-group">
				<label>Confirme a senha</label>
				<input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
				<span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Criar Conta">
				<input type="reset" class="btn btn-secondary ml-2" value="Apagar Dados">
			</div>
			<p>Já tem uma conta? <a href="login.php">Entre aqui</a>.</p>
		</form>
	</div>
</body>

</html>