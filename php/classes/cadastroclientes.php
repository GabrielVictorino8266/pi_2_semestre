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
        $query = "SELECT * FROM tb_clientes
        INNER JOIN tb_endereco ON tb_clientes.id = tb_endereco.cliente_id";
        // Preparando e executando a consulta
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        
        // Retorna todos os clientes
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarClientePorNome($nome) {
        // Consulta para buscar clientes por nome
        $query = "SELECT * FROM tb_clientes
        INNER JOIN tb_endereco ON tb_clientes.id = tb_endereco.cliente_id
        WHERE nome = :nome";
        
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

    public function buscarClientePorId($id) {
        // Consulta para buscar clientes por id e preencher ao atualizar
        $query = "SELECT tb_clientes.id as id_cliente, tb_clientes.nome, tb_clientes.telefone, tb_clientes.email, tb_endereco.* FROM tb_clientes
        INNER JOIN tb_endereco ON tb_clientes.id = tb_endereco.cliente_id
        WHERE tb_clientes.id = :id";
        
        // Preparando a consulta
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Verificando se algum cliente foi encontrado
        if($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }


    public function atualizarCliente($dados){
        $query = "UPDATE tb_clientes SET nome = :nome, email = :email, telefone = :telefone WHERE id = :id_cliente;";
        $query .= " UPDATE tb_endereco SET cep = :cep, rua = :rua, numero = :numero, cidade = :cidade, estado = :estado, bairro = :bairro WHERE cliente_id = :id_cliente";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":nome", $dados['nome'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $dados['email'], PDO::PARAM_STR);
        $stmt->bindParam(":telefone", $dados['telefone'], PDO::PARAM_STR);
        $stmt->bindParam(":id_cliente", $dados['id_cliente'], PDO::PARAM_INT);
        $stmt->bindParam(":cep", $dados['cep'], PDO::PARAM_STR);
        $stmt->bindParam(":rua", $dados['rua'], PDO::PARAM_STR);
        $stmt->bindParam(":numero", $dados['numero'], PDO::PARAM_STR);
        $stmt->bindParam(":cidade", $dados['cidade'], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $dados['estado'], PDO::PARAM_STR);
        $stmt->bindParam(":bairro", $dados['bairro'], PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }
}
?>