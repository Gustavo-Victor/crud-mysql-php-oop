<?php 
    include_once 'class/usuario.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CRUD OO PDO - Index</title>
    </head>
    <body>
        <?php 
            if(isset($_SESSION['mensagem'])){
                echo "<script>alert('".$_SESSION['mensagem']."')</script>";
                unset($_SESSION['mensagem']);
            }
        ?>
        <h1>Listar Usuários</h1>
        <table border="1"> 
            <thead>
                <tr>
                    <th>Nome</th>
                    <th colspan="3">E-mail</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $usuario = new Usuario();
                    $lista_tudo = $usuario->read();
                    if(!empty($lista_tudo)):
                        foreach($lista_tudo as $key => $value):
                ?>
                        <tr>
                            <td><?php echo $value['nome']; ?></td>
                            <td><?php echo $value['email']; ?></td>
                            <td> <a style="color:green;" href="update.php?id_usuario=<?php echo $value['id'];?>">Editar</a></td>
                            <td> <a style="color:red;" href="delete.php?id_usuario=<?php echo $value['id'];?>">Excluir</a></td>
                        </tr>
                <?php 
                        endforeach;
                    endif;
                ?>
            </tbody>
        </table>
        <br>
        <br>
        <button onclick="window.location.href='create.php'">Inserir Usuário</button>
    </body>
</html>


