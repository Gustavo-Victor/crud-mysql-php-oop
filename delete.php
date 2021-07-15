<?php 
    
include_once 'class/usuario.php';
$usuario = new Usuario();
$id_usuario;
$array = array();

if(isset($_GET['id_usuario']) && !empty($_GET['id_usuario'])){
    global $id_usuario;
    $id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
    if($usuario->delete($id_usuario)){
        $_SESSION['mensagem'] = "Usuário excluído com sucesso!";
    }else{
        $_SESSION['mensagem'] = "Falha na exclusão";
    }
}else{
    $_SESSION['mensagem'] = "Precisa selecionar um usuário para excluir";        
}

//redirecionamento padrão
header("Location: index.php");
exit();

