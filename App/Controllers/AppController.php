<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;


class AppController  extends Action {

    public function timeline(){
     
        $this->validaAutenticacao();

        // recuperar tweets
         $tweet = Container::getModel('Tweet');
         $tweet->_set('id_usuario',$_SESSION['id']);
         $tweets = $tweet->getAll();
         $this->view->tweets = $tweets;
         $this->render('timeline');
       
       
    }

    public function tweet(){

        $this->validaAutenticacao();

        $tweet = Container::getModel('Tweet');
        $tweet->_set('tweet', $_POST['tweet']);
        $tweet->_set('id_usuario', $_SESSION['id']);
        $tweet->salvar();
        header('Location: /timeline');

     
       
    }

    public function validaAutenticacao(){
        session_start();
        if(!isset($_SESSION['id']) ||$_SESSION['id'] == '' || !isset($_SESSION['nome']) ||$_SESSION['nome'] == ''){
            header('Location: /?login=erro');
        }
       
    }

    public function quemSeguir(){

        $this->validaAutenticacao();
        $usuarios = array();

        $pesquisarPor  = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] :  '';

        if($pesquisarPor != '' ){

           $usuario = Container::getModel('Usuario');
           $usuario->_set('nome', $pesquisarPor);
           $usuario->_set('id', $_SESSION['id']); 
           $usuarios = $usuario->getAll();
          
       

        }
        $this->view->usuarios = $usuarios;
       $this->render('quemSeguir');

    }

}