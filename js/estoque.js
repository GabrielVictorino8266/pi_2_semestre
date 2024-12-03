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




function aplicarMascaraMonetaria(input) {
    input.addEventListener("input", function () {
        let value = input.value;

        // Remove tudo que não for número ou vírgula
        value = value.replace(/\D/g, "");

        // Adiciona a vírgula para os centavos
        if (value.length > 2) {
            value = value.replace(/(\d{2})$/, ",$1");
        }

        // Adiciona os pontos de milhar
        if (value.length > 5) {
            value = value.replace(/(\d)(\d{3})(\d{1,2})$/, "$1.$2,$3");
        } else if (value.length > 3) {
            value = value.replace(/(\d)(\d{3})$/, "$1.$2");
        }

        // Coloca o símbolo "R$" no início
        input.value = "R$ " + value;
    });
}

  
// Aplica a função aos dois campos de valor monetário
const aplicar_atualizar_preco_venda = document.getElementById("atualizar_preco_venda");
const aplicar_atualizar_custo_unitario = document.getElementById("atualizar_custo_unitario");
const aplicar_cadastro_preco_venda = document.getElementById("cadastro_preco_venda");
const aplicar_cadastro_custo_unitario = document.getElementById("cadastro_custo_unitario");

aplicarMascaraMonetaria(aplicar_atualizar_preco_venda);
aplicarMascaraMonetaria(aplicar_atualizar_custo_unitario);
aplicarMascaraMonetaria(aplicar_cadastro_preco_venda);
aplicarMascaraMonetaria(aplicar_cadastro_custo_unitario);

function limparValorMonetario(input) {
    console.log(input);
    let value = input ? input : "";  // Verifica se a string de entrada existe, caso contrário, usa uma string vazia

    // Se o valor do input for vazio, retorna "0"
    if (!value || value.trim() === "") {
        return "0";
    }

    // Remove o símbolo R$ e qualquer outro caractere que não seja número, ponto ou vírgula
    value = value.replace(/R\$\s?/, "");  // Remove o símbolo "R$" e espaços
    value = value.replace(/[^\d,\.]/g, ""); // Remove qualquer caractere que não seja número, vírgula ou ponto

    // Remove os pontos (milhares) e deixa apenas a vírgula como separador decimal
    value = value.replace(/\.(?=\d{3})/g, ""); // Remove pontos que estão separando os milhares (não os decimais)

    // Se o valor for vazio ou apenas zeros, retorna '0' para ser enviado ao banco
    if (value === "" || value === "0" || value === "00") {
        return "0";
    }

    // Se o valor tiver vírgula, converte para ponto
    value = value.replace(",", ".");

    // Retorna o valor numérico (float)
    return parseFloat(value);
}




// Função para aplicar a máscara que permite apenas um único dígito (0 ou 1)
function aplicarMascaraBinario(input) {
    input.addEventListener("input", function () {
        // Pega o valor atual do campo
        let value = input.value;

        // Remove qualquer coisa que não seja 0 ou 1
        value = value.replace(/[^01]/g, "");

        // Permite apenas o primeiro dígito, descartando os demais
        if (value.length > 1) {
        value = value.slice(0, 1); // Mantém apenas o primeiro dígito
        }

        // Atualiza o valor do campo com a string filtrada
        input.value = value;
    });
    }

// Aplica a função ao campo de entrada
const cadastro_ativado = document.getElementById("cadastro_ativado");
const atualizar_ativado = document.getElementById("atualizar_ativado");
aplicarMascaraBinario(cadastro_ativado);
aplicarMascaraBinario(atualizar_ativado);



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
    // Obtém os valores dos inputs
    let limpar_atualizar_preco_venda = document.getElementById("atualizar_preco_venda").value;
    let limpar_atualizar_custo_unitario = document.getElementById("atualizar_custo_unitario").value;
    
    // Limpa os valores antes de enviar
    let preco_venda = limparValorMonetario(limpar_atualizar_preco_venda);
    let custo_unitario = limparValorMonetario(limpar_atualizar_custo_unitario);

    console.log(preco_venda);
    console.log(custo_unitario);

    const id_atualizacao = document.getElementById('produto_id').value;
    const dados_atualizar = {
        id: id_atualizacao,
        action: "atualizar",
        descricao: document.getElementById('atualizar_nome_produto').value,
        quantidade: document.getElementById('atualizar_quantidade').value,
        custo: custo_unitario,
        venda: preco_venda,
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
        alert('Erro na requisição. Tente novamente. Erro no frontend ao preencher');
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
    // Obtém os valores dos inputs
    let cadastro_preco_venda = document.getElementById("cadastro_preco_venda").value;
    let cadastro_custo_unitario = document.getElementById("cadastro_custo_unitario").value;

    // Limpa os valores antes de enviar
    let preco_venda = limparValorMonetario(cadastro_preco_venda);
    let custo_unitario = limparValorMonetario(cadastro_custo_unitario);

    const dados_atualizar = {
        action: "cadastrar",
        descricao: document.getElementById('cadastro_nome_produto').value,
        quantidade: document.getElementById('cadastro_quantidade').value,
        custo: custo_unitario,
        venda: preco_venda,
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