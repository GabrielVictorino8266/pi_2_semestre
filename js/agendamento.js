function visualizar(id) {
    /*
    Função que carrega as informações do agendamento ao
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
            console.log(dados_retorno);
            document.getElementById('id_agendamento').value = dados_retorno.data.id_agendamento;
            document.getElementById('receita').value = dados_retorno.data.estoque_descricao;
            document.getElementById('quantidade').value = dados_retorno.data.quantidade_receita;
            document.getElementById('preco-venda').value = dados_retorno.data.preco_venda;
            document.getElementById('status').value = dados_retorno.data.id_status;
            document.getElementById('data_retirada').value = dados_retorno.data.data_retirada;
            console.log(dados_retorno.data.data_agendamento);
            document.getElementById('data_agendamento').value = dados_retorno.data.data_agendamento;
            document.getElementById('observacoes').value = dados_retorno.data.observacoes;
        } else {
            alert(dados_retorno.message);
        }
    })
    .catch(() => {
        alert('Erro na requisição. Tente novamente. Erro no frontend');
    });
}


// function cadastrarAgendamento(){

// }