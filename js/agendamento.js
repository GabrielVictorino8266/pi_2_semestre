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

}

function excluir(){

}

function voltarAgendamento(){

}