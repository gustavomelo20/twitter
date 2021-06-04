<?php

namespace  App\Models;

use MF\Model\Model;


class Tweet extends Model{

     private $id;
     private $id_usuario;
     private $tweet;
     private $data;

     public function _get($atributo){
        return $this->$atributo;
     }
        
     public function _set($atributo, $valor){
        $this->$atributo = $valor;
     }
    
    //salvar

    public function salvar(){

        $query = "insert into tweets(id_usuario, tweet)values(:id_usuario, :tweet)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->_get('id_usuario'));
        $stmt->bindValue(':tweet', $this->_get('tweet'));
        $stmt->execute();

        return $this;
    }

}
