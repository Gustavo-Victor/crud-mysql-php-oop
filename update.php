<?php 
    include_once 'class/usuario.php';
    $usuario = new Usuario();
    $id_usuario;
    $array = array();

    if(isset($_GET['id_usuario']) && !empty($_GET['id_usuario'])){
        global $id_usuario;
        $id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
        $array = $usuario->readId($id_usuario); 
    }else{
        $_SESSION['mensagem'] = "Precisa selecionar um usuário para editar";
        header("Location: index.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CRUD OO PDO - Editar</title>
    </head>
    <body>
        <?php 
            if(isset($_SESSION['mensagem'])){
                echo "<script>alert('".$_SESSION['mensagem']."')</script>";
                unset($_SESSION['mensagem']);
            }
        ?>
        <h1>Editar Usuários</h1>
        <form action="#" method="post">
            <input type="hidden" name="id" value="<?php echo $array['id'];?>">
            <label for="nome">Nome: </label><br>    
            <input type="text" name="nome" id="nome" value="<?php echo $array['nome']; ?>" placeholder="Nome do usuário..." required="required" maxlength="70"><br><br>
            <label for="nome">E-mail: </label><br>    
            <input type="email" name="email" id="email" value="<?php echo $array['email']; ?>" placeholder="E-mail do usuário..." required="required" maxlength="70"><br><br>
            <input type="submit" value="Editar" name="editar">
        </form>
        
        <?php

            if(isset($_POST['editar'])){
                if($usuario->validate($_POST['nome'], $_POST['email'])){
                    $id_usuario = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
                    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
                    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                    $data_edicao = date("Y-m-d H:i:s"); 
                                
                    //verificar se edição deu certo
                    if($usuario->update($id_usuario, $nome, $email, $data_edicao)){
                        $_SESSION['mensagem'] = "Usuário editado com sucesso!";
                        header("Location: index.php");
                        exit();
                    }else{
                        $_SESSION['mensagem'] = "Falha no edição";
                    }
                }
                header("Location: update.php?id_usuario=$id_usuario");
            } 
        ?>
        <br>
        <br>
        <button onclick="window.location.href='index.php'">Lista de Usuários</button>
    </body>
</html>


