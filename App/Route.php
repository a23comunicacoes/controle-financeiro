<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap
{

	protected function initRoutes()
	{

		$routes['index'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['sobre_nos'] = array(
			'route' => '/sobre_nos',
			'controller' => 'indexController',
			'action' => 'sobreNos'
		);
		$routes['pegarMes'] = array(
			'route' => '/pegarMes',
			'controller' => 'indexController',
			'action' => 'pegarMes'
		);
		//PAGINAS
		$routes['receita'] = array(
			'route' => '/receita',
			'controller' => 'ProdutoController',
			'action' => 'receita'
		);
		$routes['getDespesas'] = array(
			'route' => '/getDespesas',
			'controller' => 'ProdutoController',
			'action' => 'getDespesas'
		);
		$routes['receitas'] = array(
			'route' => '/receitas',
			'controller' => 'ProdutoController',
			'action' => 'receitas'
		);
		$routes['despesa'] = array(
			'route' => '/despesa',
			'controller' => 'ProdutoController',
			'action' => 'despesa'
		);
		$routes['despesas'] = array(
			'route' => '/despesas',
			'controller' => 'ProdutoController',
			'action' => 'despesas'
		);
		$routes['novaCategoria'] = array(
			'route' => '/novaCategoria',
			'controller' => 'ProdutoController',
			'action' => 'novaCategoria'
		);
		//INSERT
		$routes['salvarReceita'] = array(
			'route' => '/salvarReceita',
			'controller' => 'ProdutoController',
			'action' => 'salvarReceita'
		);
		$routes['salvarDespesa'] = array(
			'route' => '/salvarDespesa',
			'controller' => 'ProdutoController',
			'action' => 'salvarDespesa'
		);
		$routes['salvarCategoria'] = array(
			'route' => '/salvarCategoria',
			'controller' => 'ProdutoController',
			'action' => 'salvarCategoria'
		);

		//SELECT
		$routes['contasPagas'] = array(
			'route' => '/contasPagas',
			'controller' => 'ProdutoController',
			'action' => 'contasPagas'
		);
		$routes['pagarDespesa'] = array(
			'route' => '/pagarDespesa',
			'controller' => 'ProdutoController',
			'action' => 'pagarDespesa'
		);
		$routes['naoFoiPago'] = array(
			'route' => '/naoFoiPago',
			'controller' => 'ProdutoController',
			'action' => 'naoFoiPago'
		);
		$routes['editarDespesa'] = array(
			'route' => '/editarDespesa',
			'controller' => 'ProdutoController',
			'action' => 'editarDespesa'
		);
		$routes['editarReceita'] = array(
			'route' => '/editarReceita',
			'controller' => 'ProdutoController',
			'action' => 'editarReceita'
		);
		$routes['alterarDespesa'] = [
			'route' => '/alterarDespesa',
			'controller' => 'ProdutoControllerUpdate',
			'action' => 'alterarDespesa'
		];
		$routes['updateReceita'] = [
			'route' => '/updateReceita',
			'controller' => 'ProdutoControllerUpdate',
			'action' => 'updateReceita'
		];
		$routes['excluirDespesa'] = array(
			'route' => '/excluirDespesa',
			'controller' => 'ProdutoController',
			'action' => 'excluirDespesa'
		);
		$routes['excluirReceita'] = array(
			'route' => '/excluirReceita',
			'controller' => 'ProdutoController',
			'action' => 'excluirReceita'
		);
		$routes['login'] = array(
			'route' => '/login',
			'controller' => 'UsuarioController',
			'action' => 'login'
		);
		$routes['autenticar'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);
		$routes['registrar'] = array(
			'route' => '/registrar',
			'controller' => 'UsuarioController',
			'action' => 'registrar'
		);
		$routes['cadastro'] = array(
			'route' => '/cadastro',
			'controller' => 'UsuarioController',
			'action' => 'cadastro'
		);
		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);

		$this->setRoutes($routes);
	}
}
