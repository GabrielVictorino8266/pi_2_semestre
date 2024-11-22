<?php
require_once __DIR__ . '/conexao.php'; 

class CadastroClientes {
    private $conexao;

    public function __construct() {
        // Criando uma instância da classe Conexao
        $conexao = new Conexao();
        // Obtendo a conexão do banco de dados
        $this->conexao = $conexao->getConexao(); 
    }

    public function adicionarCliente($nome, $email, $telefone) {
        // Definindo a query de inserção
        $query = "INSERT INTO tb_clientes (nome, email, telefone) VALUES (:nome, :email, :telefone)";
        
        // Preparando a consulta
        $stmt = $this->conexao->prepare($query);
        
        // Associando os parâmetros
        $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":telefone", $telefone, PDO::PARAM_STR);
        
        // Executando a consulta
        $stmt->execute();
    }

    public function listarClientes() {
        // Consulta para listar todos os clientes
        $query = "SELECT * FROM tb_clientes";
        // Preparando e executando a consulta
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        
        // Retorna todos os clientes
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarClientePorNome($nome) {
        // Consulta para buscar clientes por nome
        $query = "SELECT * FROM tb_clientes WHERE nome = :nome";
        
        // Preparando a consulta
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
        $stmt->execute();
        
        // Verificando se algum cliente foi encontrado
        if($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
}
?>

