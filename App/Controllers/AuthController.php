<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;



class AuthController extends Action
{

    public function autenticar()
    {
        
       
       $usuario = Container::getModel('Usuario');
      
        $senha = md5($_POST['senha']);
        $usuario->__set('email', $_POST['email']);
        $usuario->__set('senha', $senha);

        $usuario->autenticar(); 
       
        $this->view->usuario = $usuario;     

        if ($usuario->__get('id') != '' && $usuario->__get('nome') != '') {
            session_start();
          
            $_SESSION['id'] = $usuario->__get('id');
            $_SESSION['nome'] = $usuario->__get('nome');
            $_SESSION['email'] = $usuario->__get('email');
           

            header("Location: /");
        } else {
           header("Location:/login?login=erro");
            echo "Erro na autenticação";
        }
    }


    public function sair()
    {
        session_start();
        session_destroy();

        header("Location:/login");
    }
}
