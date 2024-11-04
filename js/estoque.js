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


// EXIBIÇÃO DE FORMULÁRIOS PARA ATUALIZAÇÃO
function mostrarFormAtualizar(id){
    /*
    Função que mostra o formulario de atualizar com os dados do produto respectivo.
    */
    const formAtualizar = document.getElementById('form_atualizar');
    formAtualizar.style.display = 'block';
    document.getElementById('produto_id').value = id;

    const dados = {
        id: id,
        action: 'preencher' // Enviando a ação como parte dos dados
    }

    $.ajax({
        url: '../pi_2_semestre/php/ctr_estoque.php',
        type: 'POST',
        data: dados,
        success: function (response) {
            console.log(response);

            const dados_retorno = JSON.parse(response);
            if(dados_retorno.success){
                $('#atualizar_nome_produto').val(dados_retorno.produto.descricao);
                $('#atualizar_custo_unitario').val(dados_retorno.produto.preco_unitario);
                $('#atualizar_preco_venda').val(dados_retorno.produto.preco_venda);
                $('#atualizar_quantidade').val(dados_retorno.produto.quantidade);
                $('#atualizar_tipo').val(dados_retorno.produto.tipo_id);
                $('#atualizar_categoria').val(dados_retorno.produto.categoria_id);
            }else{
                alert(dados_retorno.message);
            }
        },
        error: function () {
            alert('Erro na requisição. Tente novamente.');
        }
    });
}

function voltarFormularioAtualizar(){
    /*
    Função que esconde o formulario de atualização
    */
    const formAtualizar = document.getElementById('form_atualizar');
    formAtualizar.style.display = 'none';
}

// LÓGICA ATUALIZAÇÃO COM AJAX E JQUERY
function atualizar(){
    const id = document.getElementById('produto_id').value;
    const dados = {
        id: id,
        action: 'atualizar',
        descricao: document.getElementById('atualizar_nome_produto').value,
        quantidade: document.getElementById('atualizar_quantidade').value,
        custo: document.getElementById('atualizar_custo_unitario').value,
        venda: document.getElementById('atualizar_preco_venda').value,
        tipo: document.getElementById('atualizar_tipo').value,
        categoria: document.getElementById('atualizar_categoria').value,
    };

    // console.log(dados);
    $.ajax({
        url: '../pi_2_semestre/php/ctr_estoque.php',
        type: 'POST',
        data: dados,
        success: function (response) {
            console.log(response);
            const dados_retorno = JSON.parse(response);

            if(dados_retorno.success){
                alert(dados_retorno.message);
                voltarFormularioAtualizar();
            }else{
                alert(dados_retorno.message);
            }
        },
        error: function () {
            alert('Erro na requisição. Tente novamente.');
        }
    })
}

//LÓGICA DE EXCLUSÃO
function deletar(id){
    $.ajax({
        url: '../pi_2_semestre/php/ctr_estoque.php',
        type: 'POST',
        data:{
            id: id,
            action: 'deletar'
        },
        success: function (response) {
            console.log(response);
            const dados_retorno = JSON.parse(response);
            
            if(dados_retorno.success){
                alert(dados_retorno.message);
                voltarFormularioAtualizar();
            }else{
                alert(dados_retorno.message);
            }
        },
        error: function () {
            alert('Erro na requisição. Tente novamente.');
        }

    })
}


// LÓGICA DE CADASTRO
function cadastrar(){
    const dados = {
        action: 'cadastrar',
        descricao: document.getElementById('cadastro_nome_produto').value,
        quantidade: document.getElementById('cadastro_quantidade').value,
        custo: document.getElementById('cadastro_custo_unitario').value,
        venda: document.getElementById('cadastro_preco_venda').value,
        tipo: document.getElementById('cadastro_tipo').value,
        categoria: document.getElementById('cadastro_categoria').value,
    }
    console.log(dados);
    $.ajax({
        url: '../pi_2_semestre/php/ctr_estoque.php',
        type: 'POST',
        data: dados,
        success: function (response) {
            console.log(response);
            const dados_retorno = JSON.parse(response);
            if(dados_retorno.success){
                alert(dados_retorno.message);
                voltarFormularioCadastro();
            }else{
                alert(dados_retorno.message);
            }
        },
        error: function () {
            alert('Erro na requisição. Tente novamente.');
        }
    })
}