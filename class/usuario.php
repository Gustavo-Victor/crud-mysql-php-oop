<?php 

declare(strict_types = 1);

session_start();

class Usuario {
    //ATRIBUTOS
    private $conexao;

    //MÉTODOS
    //construtor
    public function __construct(){
        try{
            $this->conexao = new PDO("mysql:host=localhost; dbname=db_usuario", "root", "");
        }catch(Exception $e){
            echo "<b>Error on line ".$e->getLine()."</b>: ".$e->getMessage()."<br/>";
            die();
        }        
    }

    //create
    public function create($nome, $email, $data_criacao):bool{
        $sql = "INSERT INTO tbl_usuario (nome, email, created) VALUES (?, ?, ?)";//consulta
        $prepare = $this->conexao->prepare($sql);//preparar consulta
        $prepare->bindParam(1, $nome);//passar e filtrar parâmetros da consulta
        $prepare->bindParam(2, $email);
        $prepare->bindParam(3, $data_criacao);
        $prepare->execute(); //executar consulta
        
        if($prepare->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    //read
    public function read():array{
        $sql = "SELECT * FROM tbl_usuario";
        $prepare = $this->conexao->prepare($sql);
        $prepare->execute();

        if($prepare->rowCount()>0){
            $array = $prepare->fetchAll(PDO::FETCH_ASSOC);
            return $array;
        }else{
            return [];
        }
    }

    //read Email 
    public function readEmail($email):bool{
        $sql = "SELECT * FROM tbl_usuario WHERE email = ?";
        $prepare = $this->conexao->prepare($sql);
        $prepare->bindParam(1, $email);
        $prepare->execute();

        if($prepare->rowCount()>0){
            return true;
        }else{
            return false;
        }
    } 

    //read Id
    public function readId($id_usuario):array{
        $sql = "SELECT * FROM tbl_usuario WHERE id = ?";
        $prepare = $this->conexao->prepare($sql);
        $prepare->bindParam(1, $id_usuario);
        $prepare->execute();

        if($prepare->rowCount()>0){
            $array = $prepare->fetch(PDO::FETCH_ASSOC);
            return $array;
        }else{
            return [];
        }
    }

    //update
    public function update($id_usuario, $nome, $email, $data_edicao):bool{
        $sql = "UPDATE tbl_usuario SET nome = ?, email = ?, modified = ? WHERE id = ?";//consulta
        $prepare = $this->conexao->prepare($sql);//preparar consulta
        $prepare->bindParam(1, $nome);//passar e filtrar parâmetros da consulta
        $prepare->bindParam(2, $email);
        $prepare->bindParam(3, $data_edicao);
        $prepare->bindParam(4, $id_usuario);
        $prepare->execute(); //executar consulta

        if($prepare->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    //delete
    public function delete($id_usuario):bool{
        $sql = "DELETE FROM tbl_usuario WHERE id = ?";
        $prepare = $this->conexao->prepare($sql);
        $prepare->bindParam(1, $id_usuario);
        $prepare->execute();

        if($prepare->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    //validate
    public function validate($nome, $email):bool{
        if(empty($nome) || empty($email)){
            $_SESSION['mensagem'] = "Preencha todos os campos";
            return false;
        }elseif(strlen($nome)<4 || strlen($nome)>70){
            $_SESSION['mensagem'] = "Nome não pode ter mais de 70 ou menos que 4 caracteres";
            return false;
        }elseif(strlen($email)<11 || strlen($email)>70){
            $_SESSION['mensagem'] = "E-mail não pode ter mais que 70 ou menos que 11 caracteres";
            return false;                
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['mensagem'] = "Preencha um endereço de e-mail válido";
            return false; 
        }else{
            return true;
        }
    }

}

