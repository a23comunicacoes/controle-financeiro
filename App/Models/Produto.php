<?php

namespace App\Models;

use DateTime;
use MF\Model\Model;

class Produto extends Model
{

    private $id;
    private $id_usuario;
    private $despesa;
    private $descricao;
    private $preco;
    private $valor;
    private $categoria;
    private $nome_categoria;
    private $data_vencimento;
    private $data_pagamento;
    private $data_receita;
    private $status;

    public function __get($atributo)
    {
        return $this->$atributo;
    }
    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    /*
SALVAR RECEITA
 */
    public function salvarReceita()
    {
        $query =  "INSERT INTO receitas(valor,descricao,data_receita,id_usuario) VALUES (:valor,:descricao,:data_receita,:id_usuario)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':valor', $this->__get('valor'));
        $stmt->bindValue(':descricao', $this->__get('descricao'));
        $stmt->bindValue(':data_receita', $this->__get('data_receita'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return $this;
    }
    /*
SALVAR DESPESA
 */
    public function salvarDespesa()
    {

        $query =  "INSERT INTO despesas(despesa,descricao,valor,status,categoria,data_vencimento,id_usuario) VALUES (:despesa,:descricao,:valor,:status,:categoria,:data_vencimento,:id_usuario)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':despesa', $this->__get('despesa'));
        $stmt->bindValue(':descricao', $this->__get('descricao'));
        $stmt->bindValue(':valor', $this->__get('valor'));
        $stmt->bindValue(':status', $this->__get('status'));
        $stmt->bindValue(':categoria', $this->__get('categoria'));
        $stmt->bindValue(':data_vencimento', $this->__get('data_vencimento'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return $this;
    }

    /*
SALVAR CATEGORIA
 */
    public function salvarCategoria()
    {
        $query =  "INSERT INTO categorias(nome_categoria,id_usuario) VALUES (:nome_categoria,:id_usuario)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome_categoria', $this->__get('nome_categoria'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return $this;
    }
    /*
    ALTERAR DESPESA
 */
    public function alterarDespesa()
    {
        $query =  " UPDATE  despesas SET despesa = :despesa,descricao = :descricao,valor = :valor,categoria = :categoria, data_vencimento = :data_vencimento,id_usuario = :id_usuario WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':despesa', $this->__get('despesa'));
        $stmt->bindValue(':descricao', $this->__get('descricao'));
        $stmt->bindValue(':valor', $this->__get('valor'));
        $stmt->bindValue(':categoria', $this->__get('categoria'));
        $stmt->bindValue(':data_vencimento', $this->__get('data_vencimento'));
        //$stmt->bindValue(':status', $this->__get('status'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
        return $this;
    }
    /*
    ALTERAR RECEITA
 */
    public function updateReceita()
    {
        $query =  " UPDATE  receitas SET valor = :valor,descricao = :descricao,data_receita = :data_receita,id_usuario = :id_usuario WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':valor', $this->__get('valor'));
        $stmt->bindValue(':descricao', $this->__get('descricao'));
        $stmt->bindValue(':data_receita', $this->__get('data_receita'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
        return $this;
    }
    /*
EXCLUIR DESPESA
    */
    public function excluirDespesa()
    {
        $query = "DELETE FROM despesas WHERE id = :id and id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return $this;
    }
    /*
EXCLUIR RECEITA
    */
    public function excluirReceita()
    {
        $query = "DELETE FROM receitas WHERE id = :id and id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return $this;
    }
    /*
    ATUALIZAR PAGAMENTO
    */
    public function pagar()
    {

        $query =  "UPDATE despesas SET  status = :status, data_pagamento = date('Y/m/d'), id = :id WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(':data_pagamento', $this->__get('data_pagamento'));
        $stmt->bindValue(':status', $this->__get('status'));
        $stmt->execute();
        return $this;
    }
    //ATUALIZAR PARA CONTA ATRASADA
    public function atualizarAtrasada()
    {

        $query =  "UPDATE despesas SET  status = 'atrasada', id = :id WHERE id = :id and id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':status', $this->__get('status'));
        $stmt->execute();
        return $this;
    }
    public function getDataVencidas()
    {
        $query = "SELECT * FROM despesas WHERE  DATEDIFF(data_vencimento , now())<=1 AND status like 'a vencer' ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return   $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    //ATUALIZAR PARA CONTA NAO PAGA
    public function naoFoiPago()
    {

        $query =  "UPDATE despesas SET  status = 'a vencer', id = :id WHERE id = :id and id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':status', $this->__get('status'));
        $stmt->execute();
        return $this;
    }
    /*
PEGAR TODAS A DESPESAS
    */

    public function getAll()
    {

        $query =  "SELECT * ,MONTH(d.data_vencimento) as mes, MONTH(d.data_pagamento) as mes_pagamento  FROM despesas as d
         WHERE  d.id_usuario = :id_usuario and MONTH(d.data_vencimento)  = :data_vencimento  ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':data_vencimento', $this->__get('data_vencimento'));
        $stmt->execute();
        return   $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    /*
PEGAR TODAS A DESPESAS
    */
    public function getAllDespesasByUser()
    {
        $query =  "SELECT *,MONTH(d.data_vencimento) as mes FROM despesas as d WHERE   d.id_usuario = :id_usuario ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        //$stmt->bindValue(':data_vencimento', $this->__get('data_vencimento'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return   $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    /*
PEGAR TODAS A rRECEITAS
    */
    public function getAllReceitasByUser()
    {
        $query =  "SELECT * FROM receitas as d WHERE  d.id_usuario = :id_usuario ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return   $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    /*
PEGAR A SOMA DE TODAS AS DESPESAS
*/
    public function getSomaAllDespesas()
    {
        $query = " SELECT SUM(valor) as total FROM despesas WHERE  id_usuario = :id_usuario ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    /*
PEGAR A SOMA DE TODAS AS RECEITAS
*/
    public function getSomaAllReceitas()
    {
        $query = " SELECT * , SUM(valor) as valorReceita FROM receitas WHERE  id_usuario = :id_usuario AND month(data_receita) = date('Y/m/d')";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    /*
PEGAR TODAS A RECEITAS
    */
    public function getAllReceitas()
    {

        $query =  "SELECT * , SUM(valor) as valorReceita FROM receitas  WHERE id_usuario = :id_usuario AND month(data_receita) = :data_receita ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':data_receita', $this->__get('data_vencimento'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    /*
PEGAR DESPESA POR ID PARA EFETUAR A ALTERAÇÃO
    */
    public function getById()
    {
        $query =  "SELECT * FROM despesas  WHERE id = :id AND id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return   $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    /*
PEGAR RECEITA POR ID PARA EFETUAR UMA ALTERAÇÃO
    */
    public function getReceitaById()
    {
        $query =  "SELECT * FROM receitas  WHERE id = :id AND id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return   $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    /*
SELECT DE TODAS AS CATEGORIAS
*/
    public function getGastosPorCategorias()
    {
        $query = "SELECT *,SUM(valor) AS total_categoria FROM despesas WHERE id_usuario = :id_usuario AND MONTH(data_vencimento) = :data_vencimento  GROUP BY categoria;";
        $stmt =  $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':data_vencimento', $this->__get('data_vencimento'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /*
SELECT DE TODAS AS CATEGORIAS
*/
    public function getCategorias()
    {
        $query = "SELECT * FROM categorias ORDER BY nome_categoria";
        $stmt =  $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /*
PEGAR CONTAS PAGAS
*/
    public function getPagas()
    {
        $query = " SELECT SUM(valor) as valor FROM despesas WHERE status like 'pago' AND MONTH(data_vencimento) = :data_vencimento and id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':data_vencimento', $this->__get('data_vencimento'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    /*
PEGAR CONTAS A VENCER
*/
    public function getPagar()
    {
        $query = " SELECT *, SUM(valor) as pagar FROM despesas WHERE status like'a vencer' AND  MONTH(data_vencimento) = :data_vencimento AND id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':data_vencimento', $this->__get('data_vencimento'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    /*
    PEGAR CONTAS VENCIDAS
    */
    public function getVencidas()
    {
        $query = " SELECT *, SUM(valor) as vencidas FROM despesas WHERE data_vencimento < date('Y/m/d') and status like 'atrasada' and id_usuario = :id_usuario ORDER BY id ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /*
PEGAR CONTAS A VENCER
*/
    public function getAllDespesas()
    {
        $query = " SELECT SUM(valor) as allDespesas FROM despesas WHERE  MONTH(data_vencimento) = :data_vencimento AND id_usuario = :id_usuario ORDER BY id ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':data_vencimento', $this->__get('data_vencimento'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    /*
SELECINAR CONTAS POR MêS DE VENCIMENTO
    */
    public function pegarMes()
    {
        $query = "SELECT * FROM despesas WHERE MONTH(data_vencimento) = :data_vencimento ORDER BY id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':data_vencimento', $this->__get('data_vencimento'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //validadr se um cadastro pode ser feito
    public function validarProduto()
    {
        $valido = true;
        if (strlen($this->__get('despesa')) <= 2) {
            //$valido = false;
        }
        //if (strlen($this->__get('descricao')) <= 2) {
        //    $valido = false;
        // }
        if (is_float($this->__get('valor'))) {
            $valido = false;
        }

        return $valido;
    }
}
