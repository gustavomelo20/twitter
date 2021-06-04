<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;


class AuthController  extends Action {

    public function autenticar() {
       
       $usuario = Container::getModel('Usuario');

       $usuario->_set('email', $_POST['email']);
       $usuario->_set('senha',$_POST['senha']);
     
       $returno = $usuario->autenticar();

       if($usuario->_get('id') != '' && $usuario->_get('nome')){
           echo 'Autenticado';
       }
     
       


    }

}