// Selecionando o botão e a navbar
const hamburgerButton = document.getElementById('hamburgerButton');
const navbarMenu = document.getElementById('navbarNav');

// Detecta se o menu foi aberto ou fechado e ajusta a visibilidade do botão
navbarMenu.addEventListener('show.bs.collapse', () => {
    hamburgerButton.style.display = 'none'; // Esconde o botão quando o menu é aberto
});

navbarMenu.addEventListener('hidden.bs.collapse', () => {
    hamburgerButton.style.display = 'block'; // Mostra o botão quando o menu é fechado
});

// Fecha o menu ao clicar fora dele e exibe o botão hambúrguer
document.addEventListener('click', (event) => {
    if (!navbarMenu.contains(event.target) && !hamburgerButton.contains(event.target)) {
        const navbarCollapse = new bootstrap.Collapse(navbarMenu, { toggle: false });
        navbarCollapse.hide(); // Fecha o menu ao clicar fora
        hamburgerButton.style.display = 'block'; // Exibe o botão hambúrguer
    }
});




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


function deletar(id) {
    const id_atualizacao = id;
    const dados_excluir = {
        id: id_atualizacao,
        action: "deletar",
    };

    // console.log(dados_excluir);

    // Fazendo a requisição com fetch
    fetch('../php/ctr_estoque.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dados_excluir)
    })
    .then(response => response.json())
    .then(dados_retorno => {
        console.log(dados_retorno);

        if (dados_retorno.success) {
            alert(dados_retorno.message);
            location.reload();
        } else {
            alert(dados_retorno.message);
        }
    })
    .catch(() => {
        alert('Erro na requisição. Operação de exclusão não avançou. Tente novamente ou Contate o Suporte.');
    });
}


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