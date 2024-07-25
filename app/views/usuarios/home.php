<?php 

include __DIR__ . '/../partials/header.php';  

?>

<body>
    <p class="saudacao">Olá, seja bem-vindo ao Task Manager! <br>
    Para acessar o sistema, por favor, faça login:</p>

    <div class="container">
        <div class="login-container">
            <form action="/" method="post" class="login-form">
                <h2>Login</h2>
                <label for="email">Email:</label>
                <input type="email" id="email" placeholder="Email" name="email" >
                <label for="password">Senha:</label>
                <input type="password" id="password" placeholder="Senha"name="password">
                <button type="submit" class="login_btn">Entrar</button>
                <button type="button" class="register_btn" id="registerBtn">É novo aqui?</button>
            </form>
        </div>
        <img src="/img/icon_home.png" alt="icone_home" class="side_image">
    </div>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
