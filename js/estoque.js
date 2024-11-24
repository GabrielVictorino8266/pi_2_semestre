function mostrarFormCadastro(){
    /*
    Função que mostra o formulario de cadastro
    */
    const formCadastro = document.getElementById('form_cadastro');
    formCadastro.style.display = 'block';
}

function voltarFormularioCadastro(){
    /*
    Função que esconde o formulario de cadastro
    */
   const formCadastro = document.getElementById('form_cadastro');
   formCadastro.style.display = 'none';
}

function voltarFormularioAtualizar(){
    /*
    Função que esconde o formulario de atualização
    */
    const formAtualizar = document.getElementById('form_atualizar');
    formAtualizar.style.display = 'none';
}



function atualizar() {
    const id_atualizacao = document.getElementById('produto_id').value;
    const dados_atualizar = {
        id: id_atualizacao,
        action: "atualizar",
        descricao: document.getElementById('atualizar_nome_produto').value,
        quantidade: document.getElementById('atualizar_quantidade').value,
        custo: document.getElementById('atualizar_custo_unitario').value,
        venda: document.getElementById('atualizar_preco_venda').value,
        tipo: document.getElementById('atualizar_tipo').value,
        categoria: document.getElementById('atualizar_categoria').value,
        ativado: document.getElementById('atualizar_ativado').value,
    };

    console.log(dados_atualizar);

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
            alert("Atualização com sucesso.");
            voltarFormularioAtualizar(); // Função para fechar o formulário de atualização
            location.reload();
        } else {
            alert("Atualização sem sucesso.");
        }
    })
    .catch(() => {
        alert('Erro na requisição. Tente novamente. Frontend no atualizar.');
    });
}


function mostrarFormAtualizar(id) {
    /*
    Função que mostra o formulário de atualização com os dados do produto respectivo.
    */
   const formAtualizar = document.getElementById('form_atualizar');
   formAtualizar.style.display = 'block';
   document.getElementById('produto_id').value = id;
   
   const dados = {
       id: id,
       action: "preencher" // Enviando a ação como parte dos dados
    };

    fetch('../php/ctr_estoque.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dados)
    })
    .then(response => response.json())
    .then(dados_retorno => {
        // console.log(dados_retorno);
        if (dados_retorno.success) {
            document.getElementById('atualizar_nome_produto').value = dados_retorno.data.descricao;
            document.getElementById('atualizar_custo_unitario').value = dados_retorno.data.preco_unitario;
            document.getElementById('atualizar_preco_venda').value = dados_retorno.data.preco_venda;
            document.getElementById('atualizar_quantidade').value = dados_retorno.data.quantidade;
            document.getElementById('atualizar_tipo').value = dados_retorno.data.tipo_id;
            document.getElementById('atualizar_categoria').value = dados_retorno.data.categoria_id;
            document.getElementById('atualizar_ativado').value = dados_retorno.data.ativado;
        } else {
            alert(dados_retorno.message);
        }
    })
    .catch(() => {
        alert('Erro na requisição. Tente novamente. Erro no frontend');
    });
}


//LÓGICA DE EXCLUSÃO
/*
A logica de deleção, irá sofrer uma altereração, direta no banco
quando apagar, uma coluna de status é disparada e a própria hora de alteração
é registrada.

Isso afeterá todas as queries de consulta.

*/
// function deletar(id){
//     $.ajax({
//         url: '../pi_2_semestre/php/ctr_estoque.php',
//         type: 'POST',
//         data:{
//             id: id,
//             action: 'deletar'
//         },
//         success: function (response) {
//             console.log(response);
//             const dados_retorno = JSON.parse(response);
            
//             if(dados_retorno.success){
//                 alert(dados_retorno.message);
//                 voltarFormularioAtualizar();
//             }else{
//                 alert(dados_retorno.message);
//             }
//         },
//         error: function () {
//             alert('Erro na requisição. Tente novamente.');
//         }

//     })
// }

function cadastrar() {
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