<?php

namespace app\controllers;



class UsuariosController{

    
    public function index(){
        require __DIR__ ."/../views/usuarios/home.php";

        
    }

    public function login(){
        session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 

        $email = $_POST['email'];
        $password = $_POST['password'];

        $pdo = getConnection();

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['usuario_id'] = $user['id'];
            header('Location: /tarefas'); // redireciona para a área logada
            exit;
        } else {
            echo 'Nome de usuário ou senha inválidos!';
            header('Location /');
            exit;
        }
    
        }
    }
    public function create(){
        require __DIR__ . '/../views/usuarios/cadastrar.php'; 
    }
    public function create_user(){
        $validate = Validate(
            [
                'nome' => 's',
                'username'=> 's',
                'email'=> 'e',
                'password'=> 'p',
        
        ]);

        create_user("usuarios", $validate);

        header('Location: /');
        exit();


        

    }
}




