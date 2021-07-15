<?php 
    include_once 'class/usuario.php';
    $usuario = new Usuario();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CRUD OO PDO - Cadastrar</title>
    </head>
    <body>
        <?php 
            if(isset($_SESSION['mensagem'])){
                echo "<script>alert('".$_SESSION['mensagem']."')</script>";
                unset($_SESSION['mensagem']);
            }
        ?>
        <h1>Cadastrar Usuários</h1>
        <form action="#" method="post">
            <label for="nome">Nome: </label><br>    
            <input type="text" name="nome" id="nome" placeholder="Nome do usuário..." required="required" maxlength="70"><br><br>
            <label for="nome">E-mail: </label><br>    
            <input type="email" name="email" id="email" placeholder="E-mail do usuário..." required="required" maxlength="70"><br><br>
            <input type="submit" value="Cadastrar" name="cadastrar">
        </form>
        
        <?php

            if(isset($_POST['cadastrar'])){
                if($usuario->validate($_POST['nome'], $_POST['email'])){
                    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
                    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                    $data_criacao = date("Y-m-d H:i:s"); 
                    
                    $consultar_email = $usuario->readEmail($email);

                    if($consultar_email){
                        $_SESSION['mensagem'] = "Já existe um usuário com este e-mail. Insira outro, por favor";
                    }else{
                        if($usuario->create($nome, $email, $data_criacao)){
                            $_SESSION['mensagem'] = "Usuário cadastrado com sucesso!";
                            header("Location: index.php");
                            exit();
                        }else{
                            $_SESSION['mensagem'] = "Falha no cadastro";
                        }
                    }

                }
                header("Location: create.php");
            } 
        ?>
        <br>
        <br>
        <button onclick="window.location.href='index.php'">Lista de Usuários</button>
    </body>
</html>


