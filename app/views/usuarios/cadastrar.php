<?php 
namespace app\views\usuarios;

include(__DIR__ . '/../partials/header.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Cadastro de Usuário</title>
</head>
<body>
	<div class="register-container">
		<form class="register-form" method="POST" action="/cadastrar">
			<label for="nome">Nome:</label>
			<input type="text" id="nome" name="nome" required>
			
			<label for="username">Nome de usuário:</label>
			<input type="text" id="username" name="username" required>
			
			<label for="email">Email:</label>
			<input type="email" id="email" name="email" required>
			
			<label for="password">Senha:</label>
			<input type="password" id="password" name="password" required>
			
			<input class="register-btn" type="submit" value="Cadastrar">
		</form>
	</div>
	<?php include(__DIR__ . '/../partials/footer.php'); ?>
</body>
</html>