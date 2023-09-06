<?php

namespace App\Models;

use MF\Model\Model;
use PDO;

class Usuario extends Model
{

    private $id;
    private $nome;
    private $email;
    private $senha;
    private $chave;
    private $perfil;
    private $data_cadastro;
    private $rua;
    private $bairro;
    private $cidade;
    private $cep;
    private $sexo;
    private $foto;

    public function __get($atributo)
    {
        return $this->$atributo;
    }
    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function salvar()
    {

        $query =  "INSERT INTO usuarios(nome,email,senha,chave) VALUES (:nome,:email,:senha,:chave)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":nome", $this->__get('nome'));
        $stmt->bindValue(":email", $this->__get('email'));
        $stmt->bindValue(":senha", $this->__get('senha'));
        $stmt->bindValue(":chave", $this->__get('chave'));
        $stmt->execute();
        return $this;
    }
    //Atualizar  a foto perrifl usuario
    public function inserirImagem()
    {
        $sql = "UPDATE usuarios SET foto = :foto WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(':foto', $this->__get('foto'));
        $stmt->execute();
        return $this;
    }

    //validadr se um cadastro pode ser feito
    public function validarCadastro()
    {
        $query = "SELECT * FROM usuarios WHERE email=:email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":email", $this->__get('email'), PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // recuperar um usuario por email
    public function getUsuarioPorEmail()
    {
        $query =  "SELECT nome, email FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    /*
AUTENTICAR USUARIO
*/
    public function autenticar()
    {

        $query = "SELECT id,nome,email FROM usuarios WHERE email = :email and senha = :senha";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();

        $usuario =  $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($usuario['id'] != '' && $usuario['nome'] != '') {
            $this->__set('id', $usuario['id']);
            $this->__set('nome', $usuario['nome']);
        }

        return $this;
    }
    public function getAllAdim()
    {
        $query = "SELECT u.id,u.nome,u.perfil,u.email,u.telefone,u.rua,u.bairro,u.cidade,u.cep,u.sexo,u.foto 
        FROM usuarios as u";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getAll()
    {
        $query = "SELECT u.id,u.nome,u.perfil,u.email,u.telefone,u.rua,u.bairro,u.cidade,u.cep,u.sexo,u.foto 
        FROM usuarios as u
        
         WHERE u.id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getInfoUsuario()
    {
        $query = "SELECT id,nome,perfil,email,rua,bairro,cidade,cep,sexo,foto,data_cadastro,telefone  FROM usuarios  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));

        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function update_name()
    {
        $query =  "UPDATE usuarios SET nome = :nome WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->execute();
        return $this;
    }
    public function update_phone()
    {
        $query =  "UPDATE usuarios SET telefone = :telefone WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(':telefone', $this->__get('telefone'));
        $stmt->execute();
        return $this;
    }
    public function update_address()
    {
        $query =  "UPDATE usuarios SET rua = :rua, bairro = :bairro, cidade = :cidade, cep = :cep WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(':rua', $this->__get('rua'));
        $stmt->bindValue(':bairro', $this->__get('bairro'));
        $stmt->bindValue(':cidade', $this->__get('cidade'));
        $stmt->bindValue(':cep', $this->__get('cep'));
        $stmt->execute();
        return $this;
    }
    public function update_sexo()
    {
        $query =  "UPDATE usuarios SET sexo = :sexo WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(':sexo', $this->__get('sexo'));
        $stmt->execute();
        return $this;
    }
    /**
     * Summary of validaAutenticacao
     * @return void
     */
    public  function  validaAutenticacao()
    {
        session_start();
        if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
            header("Location:/login?login=erro");
        }
    }
}
