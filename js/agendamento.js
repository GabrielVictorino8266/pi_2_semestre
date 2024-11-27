function visualizar(id) {
    /*
    Função que carrega as informações do agendamento ao form.
    */
   document.getElementById('id_agendamento').value = id;
   
   const dados = {
       id: id,
       action: "preencher" // Enviando a ação como parte dos dados
    };

    fetch('../php/ctr_agendamento.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dados)
    })
    .then(response => response.json())
    .then(dados_retorno => {
        if (dados_retorno.success) {
            document.getElementById('id_agendamento').value = dados_retorno.data.id_agendamento;
            document.getElementById('receita').value = dados_retorno.data.estoque_id;
            document.getElementById('quantidade').value = dados_retorno.data.quantidade_receita;
            document.getElementById('preco-venda').value = dados_retorno.data.preco_venda;
            document.getElementById('status').value = dados_retorno.data.id_status;
            document.getElementById('data_retirada').value = dados_retorno.data.data_retirada;
            document.getElementById('data_agendamento').value = dados_retorno.data.data_agendamento;
            document.getElementById('observacoes').value = dados_retorno.data.observacoes;
            document.getElementById('id_cliente').value = dados_retorno.data.id_cliente;
            document.getElementById('nome_cliente').textContent = dados_retorno.data.nome_cliente;
            document.getElementById('email_cliente').textContent = dados_retorno.data.email_cliente;
            document.getElementById('telefone_cliente').textContent = dados_retorno.data.telefone_cliente;
        } else {
            alert(dados_retorno.message);
        }
    })
    .catch(() => {
        alert('Erro na requisição. Tente novamente. Erro no frontend');
    });
}

function voltarFormAtualizar(){
    /*
    Função que esconde o formulario de cadastro
    */
   const formAtualizar = document.getElementById('modalAtualizar');
   formAtualizar.style.display = 'none';
}


function atualizar(){
    const dados_atualizar = {
        id_agendamento: document.getElementById('id_agendamento').value,
        action: "atualizar",
        data_agendamento: document.getElementById('data_agendamento').value,
        produto_final_id: document.getElementById('receita').value,
        status_id: document.getElementById('status').value,
        observacoes: document.getElementById('observacoes').value,
        data_retirada: document.getElementById('data_retirada').value,
        quantidade: document.getElementById('quantidade').value,
    };

    console.log(dados_atualizar);

    fetch('../php/ctr_agendamento.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dados_atualizar)
    })
    .then(response => response.json())
    .then(dados_retorno => {
        if(dados_retorno.success){
            alert("Atualizado com sucesso.");
            location.reload();
        } else {
            alert(dados_retorno.message);
        }
    })
    .catch((error) => {
        console.log(error);
        alert('Erro na requisição de atualizar. Tente novamente. Erro no frontend');
    });
}


function cadastrarAgendamento(){
    const dados_atualizar = {
        action: "cadastrar",
        descricao: document.getElementById('cadastro_nome_produto').value,
        quantidade: document.getElementById('cadastro_quantidade').value,
        custo: document.getElementById('cadastro_custo_unitario').value,
        venda: document.getElementById('cadastro_preco_venda').value,
        tipo: document.getElementById('cadastro_tipo').value,
        categoria: document.getElementById('cadastro_categoria').value,
        ativado: document.getElementById('cadastro_ativado').value,
    };

    // Fazendo a requisição com fetch
    fetch('../php/ctr_estoque.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dados_atualizar)
    })
    .then(response => response.json())
    .then(dados_retorno => {
        console.log(dados_retorno);

        if (dados_retorno.success) {
            alert("Cadastro com sucesso.");
            voltarFormularioAtualizar(); // Função para fechar o formulário de Cadastro
            location.reload();
        } else {
            alert("Cadastro sem sucesso.");
        }
    })
    .catch(() => {
        alert('Erro na requisição. Tente novamente. Frontend no cadastrar.');
       });
}

function excluir(){

}



function buscar(termo) {
    if (termo) {
        // Faz uma requisição para o controller
        fetch(`../php/ctr_agendamento.php?termo=${encodeURIComponent(termo)}`)
            .then(response => response.json())
            .then(data => {
                caixaSugestao.innerHTML = '';
                if (Array.isArray(data) && data.length > 0) {
                    caixaSugestao.style.display = 'block'; // Exibe a caixa

                    data.forEach(cliente => {
                        const sugestao = document.createElement('div');
                        sugestao.className = 'list-group-item list-group-item-action p-2'; // Adiciona espaçamento
                        sugestao.textContent = cliente.nome_cliente;
                        sugestao.addEventListener('click', function () {
                            inputCliente.value = cliente.nome_cliente;
                            caixaSugestao.style.display = 'none'; // Oculta sugestões ao clicar
                        });
                        caixaSugestao.appendChild(sugestao);
                    });
                } else {
                    caixaSugestao.style.display = 'block';
                    caixaSugestao.innerHTML = '<div class="list-group-item text-muted">Nenhum cliente encontrado.</div>';
                }
            })
            .catch(error => {
                console.error('Erro ao buscar clientes:', error);
            });
    } else {
        caixaSugestao.style.display = 'none'; // Oculta a caixa se o termo for vazio
    }
}

// Essa variável armazena o input do nome do cliente
const inputCliente = document.getElementById('cadastrar_nome_cliente');

// Essa variável armazena o container que mostra as sugestões de clientes
const caixaSugestao = document.getElementById('caixaSugestao');

// Adiciona um listener para o clique no documento
// quando o clique for fora do container de sugestões e do input de nome do cliente
// ele limpa o container de sugestões
document.addEventListener('click', (e) => {
    if (!caixaSugestao.contains(e.target) && e.target !== inputCliente) {
        caixaSugestao.innerHTML = '';
    }
});

// Adiciona um listener para o input do nome do cliente
// quando o valor do input mudar, ele chama a função buscar
// passando o valor do input como parâmetro
inputCliente.addEventListener('input', function(){
    const termo = this.value.trim();

    if(termo){
        //Faz a requisição para o controller
        buscar(termo);
    }else {
        caixaSugestao.innerHTML = ''; // Limpa sugestões se o campo estiver vazio
    }
});
