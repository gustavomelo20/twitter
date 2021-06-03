<?php

namespace  App\Models;

use MF\Model\Model;


class Usuario extends Model{

    private $id;
    private $nome;
    private $email;
    private $senha;

    public function _get($atributo){
         return $this->$atributo;
    }
     
    public function _set($atributo, $valor){
        $this->$atributo = $valor;
    }
    //Salvar 
    public function salvar(){
         $query = " insert into usuarios(nome , email , senha)values(:nome, :email, :senha)";
         $stmt = $this->db->prepare($query);
         $stmt->bindValue(':nome',$this->_get('nome'));
         $stmt->bindValue(':email',$this->_get('email'));
         $stmt->bindValue(':senha',$this->_get('senha')); //md5 -> hash 32 caracteres
         $stmt->execute();
    }
    //validar se um cadastro pode ser feito

    public function validarCadastro(){
      $valido = true;

      if(strlen($this->_get('nome')) < 3){
        $valido = false;
      }
      if(strlen($this->_get('email')) < 3){
        $valido = false;
      }
      if(strlen($this->_get('senha')) < 3){
        $valido = false;
      }

      return $valido;
    }

    public function getUsuarioPorEmail(){
         $query = "select  nome , email from usuarios where email = :email";
         $stmt = $this->db->prepare($query);
         $stmt->bindValue(':email', $this->_get('email'));
         $stmt->execute();

         return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    
    //recuperar um usuario por email
}

?>