<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class ProdutoControllerUpdate extends Action
{
    //SALAVAR NOVA DESPESA
    public function alterarDespesa()
    {
        $usuario = Container::getModel('Usuario');
        $produto =  Container::getModel('Produto');
        $usuario->validaAutenticacao();



        //PEGAR TODAS AS CATEGORIAS
        $produto->__set('id_usuario', $_SESSION['id']);
        $categorias = $produto->getCategorias();
        $this->view->categorias =  $categorias;

        $produto->__set('id', isset($_POST['id']) ? $_POST['id'] : '');
        $produto->__set('despesa', isset($_POST['despesa']) ? $_POST['despesa'] : '');
        $produto->__set('descricao', isset($_POST['descricao']) ? $_POST['descricao'] : '');
        $valor = preg_replace("/[^0-9,]+/i", "", $_POST["valor"]);
        $valor = str_replace(",", ".", $valor);
        $produto->__set('valor', $valor);
        $produto->__set('categoria', isset($_POST['categoria']) ? $_POST['categoria'] : '');
        // $produto->__set('status', 'atrasada');
        $produto->__set('id_usuario', $_SESSION['id']);
        $produto->__set('data_vencimento', isset($_POST['data_vencimento']) ? $_POST['data_vencimento'] : '');



        //VALIDANDO DE ONDE VEIO A CHAMADA DE EXCLUIR, PARA RERTONAR PARA A MESMA PAGINA
        if (isset($_POST['update'])) {
            $url = $_POST['update'];
            if ($url == "index") {
                $produto->alterarDespesa();
                header('location:/?msg=alterado');
            } elseif ($url == "despesas") {
                $produto->alterarDespesa();

                header('location:/despesas?msg=alterado');
            }
        }
    }

    //Atualizar NOVA RECEITA
    public function updateReceita()
    {
        $usuario = Container::getModel('Usuario');
        $produto =  Container::getModel('Produto');
        $usuario->validaAutenticacao();


        //var_dump($_POST);
        $produto->__set('id', isset($_POST['id']) ? $_POST['id'] : '');
        $produto->__set('valor', isset($_POST['valor']) ? $_POST['valor'] : '');
        $produto->__set('descricao', isset($_POST['descricao']) ? $_POST['descricao'] : '');
        $produto->__set('data_receita', isset($_POST['data_receita']) ? $_POST['data_receita'] : '');
        $produto->__set('id_usuario', $_SESSION['id']);

        if ($produto->updateReceita()) {
            header('location: /receitas?msg=alterada');
        } else {
            echo "Erro ao atualizar";
        }
    }
}
