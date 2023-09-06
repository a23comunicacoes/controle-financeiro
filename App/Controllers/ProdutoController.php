<?php

namespace App\Controllers;

//os recursos do miniframework
use DateInterval;
use DateTime;
use MF\Controller\Action;
use MF\Model\Container;



class ProdutoController extends Action
{
    public function getDespesas()
    {

        $this->validaAutenticacao();

        $produto =  Container::getModel('Produto');
        $produto->__set('id_usuario', $_SESSION['id']);
        $produto->__set('data_vencimento', isset($_GET["data_vencimento"]) ? $_GET["data_vencimento"] : date("m"));
        $produtoTodasAsDespesas = $produto->getAllDespesasByUser();

        $this->view->allDespesas = $produtoTodasAsDespesas;


        //PEGAR TODAS AS DESPESAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $produto->__set('data_vencimento', isset($_GET["data_vencimento"]) ? $_GET["data_vencimento"] : date("m"));
        $produtoDespesas = $produto->getAllDespesas();
        $this->view->todasAsDespesas = $produtoDespesas;

        $this->render('getDespesas',);
    }

    public function receita()
    {
        $this->validaAutenticacao();
        $produto =  Container::getModel('Produto');
        //PEGAR TODAS AS DESPESAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $produto->__set('data_vencimento', isset($_GET["data_vencimento"]) ? $_GET["data_vencimento"]  : date("m"));
        $produtoDespesas = $produto->getAllDespesas();
        $this->view->todasAsDespesas = $produtoDespesas;

        //PEGAR TODAS AS RECEITAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $produtoReceitas = $produto->getAllReceitas();
        $this->view->todasAsReceitas = $produtoReceitas;
        $this->render('receita', 'layoutlogado');
    }

    public function despesa()
    {
        $this->validaAutenticacao();
        $produto =  Container::getModel('Produto');
        //PEGAR TODAS AS CATEGORIAS
        $categorias = $produto->getCategorias();
        $this->view->categorias =  $categorias;
        //PEGAR TODAS AS DESPESAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $produto->__set('data_vencimento', isset($_GET["data_vencimento"]) ? $_GET["data_vencimento"]  : date("m"));
        $produtoDespesas = $produto->getAllDespesas();
        $this->view->todasAsDespesas = $produtoDespesas;

        //PEGAR TODAS AS RECEITAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $produtoReceitas = $produto->getAllReceitas();
        $this->view->todasAsReceitas = $produtoReceitas;

        $this->render('despesa', 'layoutlogado');
    }
    public function novaCategoria()
    {
        $this->validaAutenticacao();
        $produto =  Container::getModel('Produto');
        //PEGAR TODAS AS CATEGORIAS
        $categorias = $produto->getCategorias();
        $this->view->categorias =  $categorias;

        $this->render('novaCategoria', 'layout');
    }
    /*
    TODAS AS DESPESAS
    */
    public function despesas()
    {
        $this->validaAutenticacao();

        $produto =  Container::getModel('Produto');
        $produto->__set('id_usuario', $_SESSION['id']);
        $produtoTodasAsDespesas = $produto->getAllDespesasByUser();;
        $this->view->allDespesas = $produtoTodasAsDespesas;


        //PEGAR TODAS AS DESPESAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $produto->__set('data_vencimento', isset($_GET["data_vencimento"]) ? $_GET["data_vencimento"]  : date("m"));
        $produtoDespesas = $produto->getAllDespesas();
        $this->view->todasAsDespesas = $produtoDespesas;

        //PEGAR TODAS AS RECEITAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $produtoReceitas = $produto->getAllReceitas();
        $this->view->todasAsReceitas = $produtoReceitas;

        $produto->__set('id_usuario', $_SESSION['id']);
        $somaDeTodasAsDespesas = $produto->getSomaAllDespesas();
        $this->view->somaDeTodasAsDespesas = $somaDeTodasAsDespesas;

        //PEGAR TODAS AS CATEGORIAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $categorias = $produto->getCategorias();
        $this->view->categorias =  $categorias;
        // PEGAR CONTAS PAGAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $produto->__set('data_vencimento', isset($data_vencimento) ? $data_vencimento : date("m"));
        $produtospagos = $produto->getPagas();
        $this->view->Pagos = $produtospagos;
        //PEGAR CONTAS VENCIDAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $produtosvencidos = $produto->getVencidas();
        $this->view->vencidos = $produtosvencidos;
        if ($this->view->vencidos['status'] == 'a vencer' and  $this->view->vencidos['data_vencimento'] > date("Y/m/d")) {
            $produto->__set('id_usuario', $_SESSION['id']);
            $produto->__set('id', $this->view->vencidos['id']);
            echo $this->view->vencidos['despesa'];
            echo $this->view->vencidos['valor'];
            $produto->atualizarAtrasada();
        }

        $this->render('despesas', 'layoutlogado');
    }
    /*
    TODAS AS RECEITAS
    */
    public function receitas()
    {
        $this->validaAutenticacao();

        $produto =  Container::getModel('Produto');

        $produto->__set('id_usuario', $_SESSION['id']);
        $produtoTodasAsReceitas = $produto->getAllReceitasByUser();;
        $this->view->allReceitas = $produtoTodasAsReceitas;

        $produto->__set('id_usuario', $_SESSION['id']);
        $somaDeTodasAsReceitas = $produto->getSomaAllreceitas();
        $this->view->somaDeTodasAsReceitas = $somaDeTodasAsReceitas;
        //PEGAR TODAS AS RECEITAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $produtoReceitas = $produto->getAllReceitas();
        $this->view->todasAsReceitas = $produtoReceitas;
        //PEGAR VALORD TODAS AS RECEITAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $produto->__set('data_vencimento', isset($data_vencimento) ? $data_vencimento : date("m"));
        $produtoReceitas = $produto->getAllReceitas();
        $this->view->todasAsReceitas = $produtoReceitas;


        //PEGAR TODAS AS DESPESAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $produto->__set('data_vencimento', isset($_GET["data_vencimento"]) ? $_GET["data_vencimento"]  : date("m"));
        $produtoDespesas = $produto->getAllDespesas();
        $this->view->todasAsDespesas = $produtoDespesas;
        // PEGAR CONTAS PAGAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $produto->__set('data_vencimento', isset($data_vencimento) ? $data_vencimento : date("m"));
        $produtospagos = $produto->getPagas();
        $this->view->Pagos = $produtospagos;
        //PEGAR TODAS AS CATEGORIAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $categorias = $produto->getCategorias();
        $this->view->categorias =  $categorias;

        $this->render('receitas', 'layoutlogado');
    }
    /*
    CONTAS PAGAS
    */
    public function contasPagas()
    {

        $this->validaAutenticacao();
        $produto =  Container::getModel('Produto');

        //PEGAR TODAS A CONTAS E FILTRADAS PELO MÊS ESCOLHIDO 
        $data_vencimento = filter_input(INPUT_GET, "data_vencimento", FILTER_SANITIZE_NUMBER_INT);
        //echo "data $data_vencimento ". date("m") ;
        $produto->__set('id_usuario', $_SESSION['id']);
        $produto->__set('data_vencimento', isset($_GET['data_vencimento']) ? $_GET['data_vencimento'] : date("m"));
        $produtos = $produto->getAll();
        $this->view->produto = $produtos;
        // PEGAR CONTAS PAGAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $produto->__set('data_vencimento', isset($data_vencimento) ? $data_vencimento : date("m"));
        $produtospagos = $produto->getPagas();
        $this->view->Pagos = $produtospagos;


        //PEGAR TODAS AS RECEITAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $produtoReceitas = $produto->getAllReceitas();
        $this->view->todasAsReceitas = $produtoReceitas;

        //PEGAR TODAS AS DESPESAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $produto->__set('data_vencimento', isset($data_vencimento) ? $data_vencimento : date("m"));
        $produtoDespesas = $produto->getAllDespesas();
        $this->view->todasAsDespesas = $produtoDespesas;


        $this->render('/contasPagas', 'layoutlogado');
    }
    //SALVAR NOVA RECEITA
    public function salvarReceita()
    {

        $this->validaAutenticacao();

        $usuario = Container::getModel('Usuario');
        $produto =  Container::getModel('Produto');
        //var_dump($_POST);

        $produto->__set('valor', isset($_POST['valor']) ? $_POST['valor'] : '');
        $produto->__set('descricao', isset($_POST['descricao']) ? $_POST['descricao'] : '');
        $produto->__set('data_receita', isset($_POST['data_receita']) ? $_POST['data_receita'] : '');
        $produto->__set('id_usuario', $_SESSION['id']);

        $produto->salvarReceita();
        header('location: /receitas?msg=receita salva');
    }
    //SALAVAR NOVA DESPESA
    public function salvarDespesa()
    {
        $this->validaAutenticacao();

        $usuario = Container::getModel('Usuario');
        $produto =  Container::getModel('Produto');

        //PEGAR TODAS AS CATEGORIAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $categorias = $produto->getCategorias();
        $this->view->categorias =  $categorias;



        //VERIFICAR SE TODOS OS CAMPOS FORAM PREENCHIDOS CORRETAMENTE PARA PODER SALVAR
        if ($produto->validarProduto()) {
            if (isset($_POST['repetir'])) {
                $data_vencimento = $_POST['data_vencimento'];
                for ($i = 0; $i < 2; $i++) {

                    $produto->__set('despesa', isset($_POST['despesa']) ? $_POST['despesa'] : '');
                    $produto->__set('descricao', isset($_POST['descricao']) ? $_POST['descricao'] : '');
                    $valor = preg_replace("/[^0-9,]+/i", "", $_POST["valor"]);
                    $valor = str_replace(",", ".", $valor);
                    $produto->__set('valor', $valor);
                    $produto->__set('status', "a vencer");
                    $produto->__set('categoria', isset($_POST['categoria']) ? $_POST['categoria'] : '');
                    $produto->__set('id_usuario', $_SESSION['id']);
                    $produto->__set('data_vencimento', $data_vencimento);
                    $data_vencimento = date('Y-m-d', strtotime('+1 month', strtotime($_POST['data_vencimento'])));
                    //$produto->__set('data_vencimento', isset($_POST['data_vencimento']) ? $_POST['data_vencimento'] : '');
                    $produto->salvarDespesa();
                }

                $mes = new DateTime($_POST['data_vencimento']);
                $atual = $mes->format('m'); // Irá exibir o mês/ano atual
                header("location: /?data_vencimento={$atual}&msg=cadastrado");

                // $data_vencimento = date('Y-m-d H:m:s', strtotime('+1 month', strtotime($atividade['DT_VENCIMENTO']))); /*1 mês*/
            } else {

                if (isset($_POST['status'])) {
                    $produto->__set('despesa', isset($_POST['despesa']) ? $_POST['despesa'] : '');
                    $produto->__set('descricao', isset($_POST['descricao']) ? $_POST['descricao'] : '');
                    $valor = preg_replace("/[^0-9,]+/i", "", $_POST["valor"]);
                    $valor = str_replace(",", ".", $valor);
                    $produto->__set('valor', $valor);
                    $produto->__set('status', $_POST['status']);
                    $produto->__set('categoria', isset($_POST['categoria']) ? $_POST['categoria'] : '');
                    $produto->__set('id_usuario', $_SESSION['id']);
                    $produto->__set('data_vencimento', isset($_POST['data_vencimento']) ? $_POST['data_vencimento'] : '');
                } else {

                    $produto->__set('despesa', isset($_POST['despesa']) ? $_POST['despesa'] : '');
                    $produto->__set('descricao', isset($_POST['descricao']) ? $_POST['descricao'] : '');
                    $valor = preg_replace("/[^0-9,]+/i", "", $_POST["valor"]);
                    $valor = str_replace(",", ".", $valor);
                    $produto->__set('valor', $valor);
                    $produto->__set('status', "a vencer");
                    $produto->__set('categoria', isset($_POST['categoria']) ? $_POST['categoria'] : '');
                    $produto->__set('id_usuario', $_SESSION['id']);
                    $produto->__set('data_vencimento', isset($_POST['data_vencimento']) ? $_POST['data_vencimento'] : '');
                }

                $produto->salvarDespesa();
                $mes = new DateTime($_POST['data_vencimento']);
                $atual = $mes->format('m'); // Irá exibir o mês/ano atual
                header("location: /?data_vencimento={$atual}&msg=cadastrado");
            }
        } else {

            $this->view->produto = array(
                'despesa' => isset($_POST['despesa']) ? $_POST['despesa'] : '',
                'descricao' => isset($_POST['descricao']) ? $_POST['descricao'] : '',
                'valor' => isset($_POST['valor']) ? $_POST['valor'] : '',
                'categoria' => isset($_POST['categoria']) ? $_POST['categoria'] : '',
                'data_vencimento' => isset($_POST['data_vencimento']) ? $_POST['data_vencimento'] : '',

            );

            $this->view->erroProduto = true;
            //  $this->render('despesa', 'layoutlogado');
        }

        /*
        CODIGO ORIGINAL
        //VERIFICAR SE TODOS OS CAMPOS FORAM PREENCHIDOS CORRETAMENTE PARA PODER SALVAR
        if ($produto->validarProduto()) {
           
            $produto->salvarDespesa();
            $mes = new DateTime($_POST['data_vencimento']);
            $atual = $mes->format('m'); // Irá exibir o mês/ano atual
            header("location: /?data_vencimento={$atual}&msg=despesa cadastrada");
        } else {

            $this->view->produto = array(
                'despesa' => isset($_POST['despesa']) ? $_POST['despesa'] : '',
                'descricao' => isset($_POST['descricao']) ? $_POST['descricao'] : '',
                'valor' => isset($_POST['valor']) ? $_POST['valor'] : '',
                'categoria' => isset($_POST['categoria']) ? $_POST['categoria'] : '',
                'data_vencimento' => isset($_POST['data_vencimento']) ? $_POST['data_vencimento'] : '',

            );

            $this->view->erroProduto = true;
            //  $this->render('despesa', 'layoutlogado');
        }
        */
    }
    //SALVAR NOVA CATEGORIA
    public function salvarCategoria()
    {

        $this->validaAutenticacao();

        $usuario = Container::getModel('Usuario');
        $produto =  Container::getModel('Produto');

        $produto->__set('nome_categoria', isset($_POST['nome_categoria']) ? $_POST['nome_categoria'] : '');
        $produto->__set('id_usuario', $_SESSION['id']);

        $produto->salvarCategoria();
        header('location: /despesa');
    }

    public function pagarDespesa()
    {
        $this->validaAutenticacao();
        $produto =  Container::getModel('Produto');

        $id = $produto->__set('id', isset($_POST['id']) ? $_POST['id'] : '');
        $produto->__set('status', isset($_POST['status']) ? $_POST['status'] : '');

        $produto->pagar($id);
        header('location:/');
    }
    /*
    DESPESA FOI PAGA POR ENGANO, DESFAZER PAGAMENTO
    */
    public function naoFoiPago()
    {
        $this->validaAutenticacao();
        $produto =  Container::getModel('Produto');

        $produto->__set('id', isset($_POST['id']) ? $_POST['id'] : '');
        $produto->__set('id_usuario', $_SESSION['id']);
        $produto->__set('status', isset($_POST['status']) ? $_POST['status'] : '');

        $produto->naoFoiPago();
        header('location:/contasPagas');
    }
    // VIEW EDITAR DESPESA
    public function editarDespesa()
    {
        $this->validaAutenticacao();

        $produto =  Container::getModel('Produto');
        $id_produto = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        $produto->__set('id', $id_produto);
        $produto->__set('id_usuario', $_SESSION['id']);
        $produtoById =  $produto->getById();
        $this->view->getProdById = $produtoById;


        //PEGAR TODAS AS CATEGORIAS
        $categorias = $produto->getCategorias();
        $this->view->categorias =  $categorias;

        $this->render('editarDespesa', 'layoutlogado');
    }
    //VIEW EDITAR RECEITAS
    public function editarReceita()
    {

        $this->validaAutenticacao();

        $produto =  Container::getModel('Produto');
        $id_produto = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        $produto->__set('id', $id_produto);
        $produto->__set('id_usuario', $_SESSION['id']);
        $produtoById =  $produto->getReceitaById();
        $this->view->getReceitaById = $produtoById;


        //PEGAR TODAS AS CATEGORIAS
        $categorias = $produto->getCategorias();
        $this->view->categorias =  $categorias;

        $this->render('editarReceita', 'layoutlogado');
    }
    //EXCLUIR DESPESA
    public function excluirDespesa()
    {
        $this->validaAutenticacao();

        $usuario = Container::getModel('Usuario');
        $produto =  Container::getModel('Produto');

        $produto->__set('id', isset($_POST['id']) ? $_POST['id'] : '');
        $produto->__set('id_usuario', $_SESSION['id']);

        //VALIDANDO DE ONDE VEIO A CHAMADA DE EXCLUIR, PARA RERTONAR PARA A MESMA PAGINA
        if (isset($_POST['delete'])) {
            $url = $_POST['delete'];
            if ($url == "index") {
                $produto->excluirDespesa();
                header('location:/');
            } elseif ($url == "despesas") {
                $produto->excluirDespesa();

                header('location:/despesas');
            }
        }
    }
    //EXCLUIR RECEITA
    public function excluirReceita()
    {
        $this->validaAutenticacao();

        $usuario = Container::getModel('Usuario');
        $produto =  Container::getModel('Produto');

        $produto->__set('id', isset($_POST['id']) ? $_POST['id'] : '');
        $produto->__set('id_usuario', $_SESSION['id']);

        $produto->excluirReceita();

        header('location:/receitas');
    }
    public  function  validaAutenticacao()
    {
        session_start();
        if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
            header("Location:/login?login=erro");
        }
    }
}
