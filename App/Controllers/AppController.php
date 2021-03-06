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

         $comentarios = $tweet->getComentario();
         $this->view->comentario = $comentarios;

         $usuario = Container::getModel('Usuario');
         $usuario->_set('id',$_SESSION['id']);

         $this->view->info_usuario = $usuario->getInfosUsuarios();
         $this->view->total_tweets = $usuario->getTotalTweets();
         $this->view->seguindo = $usuario->getTotalSeguindo();
         $this->view->seguidores = $usuario-> getTotalSeguidores();

         $this->render('timeline');

         



       
       
    }




    public function tweet(){

        $this->validaAutenticacao();

        $tweet = Container::getModel('Tweet');
        $tweet->_set('tweet', $_POST['tweet']);
        $tweet->_set('id_usuario', $_SESSION['id']);
        $tweet->salvar();

        if($_POST['perfil'] == 1){
          header('Location: /perfil');  
        }else{
          header('Location: /timeline'); 
        }
       

     
       
    }


    public function comentario(){

        $this->validaAutenticacao();

        $tweet = Container::getModel('Tweet');
        $tweet->_set('id_tweet', $_POST['tweet']);
        $tweet->_set('comentario', $_POST['comentario']);
        $tweet->_set('id_usuario', $_SESSION['id']);
        $tweet->salvarComentario(); 
        
        header('Location: /timeline');


    }

    public function config(){
         $this->validaAutenticacao();

         
         


        $this->render('config');

    }


    public function perfil(){

    
         $this->validaAutenticacao();
         if(isset($_GET['usuario']) ==  ''){
                
            header('Location: /timeline');
         }

        // recuperar tweets
         $tweet = Container::getModel('Tweet');
         $tweet->_set('id_usuario',$_SESSION['id']);
         $tweets = $tweet->getAll();
         $this->view->tweets = $tweets;
         $usuario = Container::getModel('Usuario');
         $usuario->_set('id',$_SESSION['id']);

         $this->view->info_usuario = $usuario->getInfosUsuarios();

         
       
         $this->view->total_tweets = $usuario->getTotalTweets();
         $this->view->seguindo = $usuario->getTotalSeguindo();
         $this->view->seguidores = $usuario-> getTotalSeguidores();

         $this->render('perfil');

       
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
         $usuario = Container::getModel('Usuario');
         $usuario->_set('id',$_SESSION['id']);

         $this->view->info_usuario = $usuario->getInfosUsuarios();
         $this->view->total_tweets = $usuario->getTotalTweets();
         $this->view->seguindo = $usuario->getTotalSeguindo();
         $this->view->seguidores = $usuario-> getTotalSeguidores();
         $this->view->lista_seguidores = $usuario-> getAll();
         $this->view->usuarios = $usuarios;
         $this->render('quemSeguir');

    }
    public function acao(){
         $this->validaAutenticacao();
         
         $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
         $id_usuario_seguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';
         $usuario = Container::getModel('Usuario');
         $usuario->_set('id' , $_SESSION['id']);

         if($acao == 'seguir'){
             $usuario->seguirUsuario($id_usuario_seguindo);
              
         }else if($acao == "deixar_de_seguir"){
            $usuario->deixarSeguirUsuario($id_usuario_seguindo);    
         }
        header('Location: /quem_seguir');
    }


    public function  deletarTweet(){

        $this->validaAutenticacao();
        $tweet = Container::getModel('Tweet');
        $tweet->_set('id', $_POST['tweet']);
        $tweet->deletar();
        header('location:/timeline');
      
      
    }
  
    

   

}