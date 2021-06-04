<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {
		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';

		$this->render('index');

	}
	public function inscreverse() {
		$this->view->usuario = array(
			'nome' => '',
			'email' => '',
			'senha' => '',
		  );
		$this->view->erroCadastro = false;

		$this->render('inscreverse');
	}
	public function registrar() {
 
	

		$usuarios = Container::getModel('Usuario');
        
		$usuarios->_set('nome', $_POST['nome']);
		$usuarios->_set('email', $_POST['email']);
		$usuarios->_set('senha', md5($_POST['senha']));

		if($usuarios->validarCadastro() && count($usuarios->getUsuarioPorEmail()) == 0 ){
			
				 $usuarios->salvar();

				 $this->render('cadastro');
	
		}else{  
             
			$this->view->usuario = array(
              'nome' => $_POST['nome'],
			  'email' => $_POST['email'],
			  'senha' => $_POST['senha']
			);

			$this->view->erroCadastro = true;

			$this->render('inscreverse');
		}
	   
	}

}


?>