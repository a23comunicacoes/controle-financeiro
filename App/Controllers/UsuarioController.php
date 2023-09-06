<?php

namespace App\Controllers;

//os recursos do miniframework

use PHPMailer\PHPMailer\SMTP;

use MF\Controller\Action;
use MF\Model\Container;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;



class UsuarioController extends Action
{
    public function perfil()
    {
        //session_start();
        $this->validaAutenticacao();

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);
        //$usuarios = $usuario->getInfoUsuario();
        $usuarios = $usuario->getAll();

        $this->view->usuario = $usuarios;

        $this->render('perfil', 'layout');
    }
    public function cadastro()
    {
        $this->view->usuario = array(
            'nome' => '',
            'email' => '',
            'senha' => ''
        );

        $this->view->erroCadastro = false;
        $this->render('cadastro', 'layout');
    }


    public function registrar()
    {
        $this->view->erroCadastro = false;
        //receber os dados do formulario
        $usuario = Container::getModel('Usuario');

        if (empty($_POST['nome'])) {
            $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>"];
        } elseif (empty($_POST['email'])) {
            $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo e-mail!</div>"];
        } elseif (empty($_POST['senha'])) {
            $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo senha!</div>"];
        } else {


            $usuario->__set('nome', $_POST['nome']);
            $usuario->__set('email', $_POST['email']);
            $senha = md5($_POST['senha']);
            $usuario->__set('senha', $senha);
            $chave = password_hash($_POST['email'] . date("Y-m-d H:i:s"), PASSWORD_DEFAULT);
            $usuario->__set('chave', $chave);

            $resultadoConsulta =  $usuario->validarCadastro();


            if (($resultadoConsulta) and ($resultadoConsulta['email']->rowCount() != 0)) {
                echo ($resultadoConsulta['email']);
                $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: O e-mail já está cadastrado!</div>"];
            } else {
                // var_dump($resultadoConsulta);
                $cad_usuario = $usuario->salvar();
                if ($cad_usuario->rowCount()) {

                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                        $mail->CharSet = "UTF-8";
                        $mail->isSMTP();
                        $mail->Host       = 'sandbox.smtp.mailtrap.io';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'ea29fc4e8f4598';
                        $mail->Password   = 'ec62ce44ebd4e0';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = 2525;

                        //Recipients
                        $mail->setFrom('wianclodaldo43@gmail.com', 'Wian');
                        $mail->addAddress($_POST['email'], $_POST['nome']);
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'Confirma o e-mail';
                        $mail->Body    = "Prezado(a) " . $_POST['nome'] . ".<br><br>Agradecemos a sua solicitação de cadastramento em nosso site!<br><br>Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: <br><br> <a href='http://localhost/enviarEmailConfirmarCadastro/confirmar-email.php?chave=$chave'>Clique aqui</a><br><br>Esta mensagem foi enviada a você pela empresa XXX.<br>Você está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.<br><br>";
                        $mail->AltBody = "Prezado(a) " . $_POST['nome'] . ".\n\nAgradecemos a sua solicitação de cadastramento em nosso site!\n\nPara que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: \n\n http://localhost/enviarEmailConfirmarCadastro/confirmar-email.php?chave=$chave \n\nEsta mensagem foi enviada a você pela empresa XXX.\nVocê está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.\n\n";

                        $mail->send();

                        $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Usuário cadastrado com sucesso. Necessário acessar a caixa de e-mail para confimar o e-mail!</div>"];
                    } catch (Exception $e) {
                        //$retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Usuário não cadastrado com sucesso!</div>"];

                        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Usuário não cadastrado com sucesso.</div>"];
                    }
                } else {
                    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Usuário não cadastrado com sucesso!</div>"];
                }
            }
        }
        echo json_encode($retorna);/*
        $this->view->sucessoCadastro = false;

        if ($usuario->validarCadastro() && count($usuario->getUsuarioPorEmail()) == 0) {
            $usuario->salvar();
            $this->view->sucessoCadastro = true;
            $this->view->erroCadastro = false;
            $this->render('cadastro', 'layout');
        } else {

            $this->view->usuario = array(
                'nome' => isset($_POST['nome']) ? $_POST['nome'] : '',
                'email' => isset($_POST['email']) ? $_POST['email'] : '',
                'senha' => isset($_POST['senha']) ? $_POST['senha'] : ''

            );
            $this->view->erroCadastro = true;
            $this->render('cadastro', 'layout');
        }*/
    }

    public function login()
    {
        $this->view->login = false;
        $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
        $this->render('login', 'layout');
    }

    public function usuarios_cadastrado()
    {
        //session_start();
        // $this->validaAutenticacaoAdmin();

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);
        $usuarios = $usuario->getAllAdim();

        $this->view->usuario = $usuarios;
        $this->render('usuarios_cadastrado', 'layout');
    }
    //UPLOAD DO PRODUTO POSTADO
    public function carregarFotos()
    {
        //$this->validaAutenticacaoAdmin();

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);
        $post =  Container::getModel('Post');
        $posts = $post->getLastId();

        if (isset($_FILES['foto'])) {

            $extensao = strtolower(substr($_FILES['foto']['name'], -4)); //pega a extensao do arquivo
            $novo_nome = md5(time()) . $extensao; //define o nome do arquivo
            $diretorio = "upload-perfil/"; //define o diretorio para onde enviaremos o arquivo
        }
        move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio . $novo_nome); //efetua o upload



        $usuario->__set('id', $_SESSION['id']);
        $usuario->__set('foto', $novo_nome);
        $usuario->inserirImagem();

        $usuarios = $usuario->getInfoUsuario();
        $this->view->usuario = $usuarios;
        header("Location:/perfil");
    }
    public function foto_perfil()
    {
        session_start();
        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        $usuarios = $usuario->getInfoUsuario();
        $this->view->usuario = $usuarios;

        $this->render('foto_perfil', 'layout');
    }
    public function alterar_nome()
    {
        session_start();
        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        $usuarios = $usuario->getInfoUsuario();
        $this->view->usuario = $usuarios;

        $this->render('alterar_nome', 'layout');
    }
    public function alterar_telefone()
    {
        session_start();
        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        $usuarios = $usuario->getInfoUsuario();
        $this->view->usuario = $usuarios;

        $this->render('alterar_telefone', 'layout');
    }
    public function alterar_endereco()
    {
        session_start();
        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        $usuarios = $usuario->getInfoUsuario();
        $this->view->usuario = $usuarios;

        $this->render('alterar_endereco', 'layout');
    }
    public function alterar_sexo()
    {
        session_start();
        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        $usuarios = $usuario->getInfoUsuario();
        $this->view->usuario = $usuarios;

        $this->render('alterar_sexo', 'layout');
    }
    //atualizar nome de usuario
    public function update_name()
    {
        session_start();
        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);
        $usuario->__set('nome', $_POST['nome']);

        $usuario->update_name();
        header('Location: perfil');
    }
    //atualizar nome de usuario
    public function update_phone()
    {
        session_start();
        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);
        $usuario->__set('telefone', $_POST['telefone']);

        $usuario->update_phone();
        header('Location: perfil');
    }
    //atualizar nome de usuario
    public function update_adress()
    {
        session_start();
        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);
        $usuario->__set('rua', $_POST['rua']);
        $usuario->__set('bairro', $_POST['bairro']);
        $usuario->__set('cidade', $_POST['cidade']);
        $usuario->__set('cep', $_POST['cep']);

        $usuario->update_address();
        header('Location: perfil');
    }
    public function update_sexo()
    {
        session_start();
        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);
        $usuario->__set('sexo', $_POST['sexo']);

        $usuario->update_sexo();
        header('Location: perfil');
    }

    //VALIDAÇÃO DE AUTENTICAÇÃO DE USUARIOS LOGADOS
    public  function  validaAutenticacao()
    {
        session_start();
        if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
            header("Location:/login?login=erro");
        }
    }
}
