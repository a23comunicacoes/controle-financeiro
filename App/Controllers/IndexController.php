<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action
{

	public function index()
	{

		$this->validaAutenticacao();

		$produto =  Container::getModel('Produto');

		//PEGAR TODAS A CONTAS E FILTRADAS PELO MÊS ESCOLHIDO 
		$data_vencimento = $_GET["data_vencimento"];
		//echo "data $data_vencimento ". date("m") ;

		$produto->__set('data_vencimento', isset($_GET["data_vencimento"]) ?  $_GET["data_vencimento"] : date('m'));
		$produto->__set('id_usuario', $_SESSION['id']);
		$produtos = $produto->getAll();
		$this->view->produto = $produtos;
		//tentanto atualizar status para atrasada
		$vencidas = $produto->getDataVencidas();
		$this->view->dataVencida = $vencidas;
		if ($this->view->dataVencida['status'] == 'a vencer' and $this->view->dataVencida['data_vencimento'] < date("Y/m/d")) {
			$produto->__set('id_usuario', $_SESSION['id']);
			$produto->__set('id', $this->view->dataVencida['id']);
			$produto->atualizarAtrasada();
		}

		//PEGAR VALORD TODAS AS RECEITAS
		$produto->__set('id_usuario', $_SESSION['id']);
		$produto->__set('data_vencimento', isset($data_vencimento) ? $data_vencimento : date("m"));
		$produtoReceitas = $produto->getAllReceitas();
		$this->view->todasAsReceitas = $produtoReceitas;

		//PEGAR VALOR TODAS AS DESPESAS
		$produto->__set('id_usuario', $_SESSION['id']);
		$produto->__set('data_vencimento', isset($data_vencimento) ? $data_vencimento : date("m"));
		$produtoDespesas = $produto->getAllDespesas();
		$this->view->todasAsDespesas = $produtoDespesas;

		$produto->__set('id_usuario', $_SESSION['id']);
		$produto->__set('data_vencimento', isset($_GET["data_vencimento"]) ? $_GET["data_vencimento"] : date("m"));
		$produtoTodasAsDespesas = $produto->getAllDespesasByUser();

		$this->view->allDespesas = $produtoTodasAsDespesas;

		//PEGAR VALOR CONTAS A PAGAR
		$produto->__set('id_usuario', $_SESSION['id']);
		$produto->__set('data_vencimento', isset($data_vencimento) ? $data_vencimento : date("m"));
		$produtosapagar = $produto->getPagar();
		$this->view->Pagar = $produtosapagar;

		//PEGAR CONTAS PELO MêS
		//$produto =  Container::getModel('Produto');		
		$data_vencimento = filter_input(INPUT_GET, "data_vencimento", FILTER_SANITIZE_NUMBER_INT);
		$produto->__set('data_vencimento', isset($data_vencimento) ? $data_vencimento : date("m"));
		$produtoPorMes = $produto->pegarMes();
		$this->view->produtoPorMes = $produtoPorMes;

		//PEGAR CONTAS VENCIDAS
		$produto->__set('id_usuario', $_SESSION['id']);
		$produtosvencidos = $produto->getVencidas();
		$this->view->vencidos = $produtosvencidos;
		if ($this->view->vencidos['status'] == 'a vencer' and  $this->view->vencidos['data_vencimento'] < date("Y/m/d")) {
			$produto->__set('id_usuario', $_SESSION['id']);
			$produto->__set('id', $this->view->vencidos['id']);
			echo $this->view->vencidos['despesa'];
			echo $this->view->vencidos['valor'];
			$produto->atualizarAtrasada();
		}

		//PEGAR TODAS AS CATEGORIAS
		$produto->__set('id_usuario', $_SESSION['id']);
		$categorias = $produto->getCategorias();
		$this->view->categorias =  $categorias;

		//PEGAR TODAS AS CATEGORIAS
		$data_vencimento = filter_input(INPUT_GET, "data_vencimento", FILTER_SANITIZE_NUMBER_INT);
		$produto->__set('data_vencimento', isset($data_vencimento) ? $data_vencimento : date("m"));
		$produto->__set('id_usuario', $_SESSION['id']);
		$gastosCategorias = $produto->getGastosPorCategorias();
		$this->view->gastosPorCategorias =  $gastosCategorias;
		// PEGAR CONTAS PAGAS
		$produto->__set('id_usuario', $_SESSION['id']);
		$produto->__set('data_vencimento', isset($data_vencimento) ? $data_vencimento : date("m"));
		$produtospagos = $produto->getPagas();
		$this->view->Pagos = $produtospagos;

		$this->render('index', 'layoutlogado');
	}

	public  function  validaAutenticacao()
	{
		session_start();
		if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
			header("Location:/login");
		}
	}
}
