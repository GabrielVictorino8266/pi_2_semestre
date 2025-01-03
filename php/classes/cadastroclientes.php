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

    public function adicionarCliente($dados) {

    try{
        // Definindo a query de inserção
        $this->conexao->beginTransaction();

        $query = "INSERT INTO tb_clientes (nome, email, telefone) VALUES (:nome, :email, :telefone);";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":nome", $dados['nome'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $dados['email'], PDO::PARAM_STR);
        $stmt->bindParam(":telefone", $dados['telefone'], PDO::PARAM_STR);
        $stmt->execute();
        
        
        $cliente_id = $this->conexao->lastInsertId();
        $queryEndereco = "INSERT INTO tb_endereco (cep, rua, numero, cidade, estado, bairro, cliente_id) VALUES (:cep, :rua, :numero, :cidade, :estado, :bairro, :cliente_id);";
        $stmt = $this->conexao->prepare($queryEndereco);
                
        // Associando os parâmetros
        $stmt->bindParam(":cep", $dados['cep'], PDO::PARAM_STR);
        $stmt->bindParam(":rua", $dados['rua'], PDO::PARAM_STR);
        $stmt->bindParam(":numero", $dados['numero'], PDO::PARAM_STR);
        $stmt->bindParam(":cidade", $dados['cidade'], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $dados['estado'], PDO::PARAM_STR);
        $stmt->bindParam(":bairro", $dados['bairro'], PDO::PARAM_STR);
        $stmt->bindParam(":cliente_id", $cliente_id, PDO::PARAM_INT);
        
        // Executando a consulta
        if($stmt->execute()){
            $this->conexao->commit();
            return true;
        }
    }catch (Exception $e) {
            // Em caso de erro, reverte a transação
            $this->conexao->rollBack();
            throw new Exception("Erro ao cadastrar cliente e endereço: " . $e->getMessage());
        }
    }


    public function pesquisarClientes($nome) {
        // Consulta para listar todos os clientes
        $query = "SELECT tb_clientes.id as id_cliente, tb_clientes.nome, tb_clientes.telefone, tb_clientes.email, tb_endereco.* FROM tb_clientes
        INNER JOIN tb_endereco ON tb_clientes.id = tb_endereco.cliente_id 
        WHERE nome LIKE :nome";

        $nome = "%".$nome."%";

        // Preparando e executando a consulta
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
        $stmt->execute();
        
        // Retorna todos os clientes
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        // Iniciar transação
        $this->conexao->beginTransaction();
        try{
            $query = "UPDATE tb_clientes SET nome = :nome, email = :email, telefone = :telefone WHERE id = :id_cliente;";
            $stmt_cliente = $this->conexao->prepare($query);
            $stmt_cliente->bindParam(":nome", $dados['nome'], PDO::PARAM_STR);
            $stmt_cliente->bindParam(":email", $dados['email'], PDO::PARAM_STR);
            $stmt_cliente->bindParam(":telefone", $dados['telefone'], PDO::PARAM_STR);
            $stmt_cliente->bindParam(":id_cliente", $dados['id_cliente'], PDO::PARAM_INT);
            $stmt_cliente->execute();
            
            // Atualizar a tabela tb_endereco
            $queryendereco = " UPDATE tb_endereco SET cep = :cep, rua = :rua, numero = :numero, cidade = :cidade, estado = :estado, bairro = :bairro WHERE cliente_id = :id_cliente";
            $stmtendereco = $this->conexao->prepare($queryendereco);
            $stmtendereco->bindParam(":cep", $dados['cep'], PDO::PARAM_STR);
            $stmtendereco->bindParam(":rua", $dados['rua'], PDO::PARAM_STR);
            $stmtendereco->bindParam(":numero", $dados['numero'], PDO::PARAM_STR);
            $stmtendereco->bindParam(":cidade", $dados['cidade'], PDO::PARAM_STR);
            $stmtendereco->bindParam(":estado", $dados['estado'], PDO::PARAM_STR);
            $stmtendereco->bindParam(":bairro", $dados['bairro'], PDO::PARAM_STR);
            $stmtendereco->bindParam(":id_cliente", $dados['id_cliente'], PDO::PARAM_INT);
            $stmtendereco->execute();

            // Commit da transação
            $this->conexao->commit();

            // Retorna true se as duas instruções executaram corretamente
            return true;
        }catch (Exception $e) {
            // Em caso de erro, realiza o rollback
            $this->conexao->rollBack();
            // Exibe a mensagem de erro para depuração (pode remover ou registrar em produção)
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }
}
?>