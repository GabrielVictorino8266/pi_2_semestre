# Documentação técnica de código

> Última atualização: 15/11/2024

Este documentto contempla toda a documentação técnica de código

### Sumário

- [Processo Login](#1-processo-login)
- [Processo Dashboard](#2-processo-dashboard)
- [Processo Estoque](#3-processo-de-estoque)
- [Processo Agendamento](#4-processo-de-agendamento)
- [Processo Cadastrar Usuário](#5-processo-de-cadastro-de-usuário)


## 1. Processo Login

O processo de login envolve o frontend, controller e banco de dados para consulta das informações.

Diagrama de Fluxo Geral
<details>
    <summary>Visualizar diagrama.</summary>
    <h3>Diagrama de Fluxo de Login</h3> 
    <img src="./assets/login_fluxo_geral.png" alt="Fluxo Geral de Login"><br><br>

</details>

Classes e arquivos utilizados no processo:
- Conexao
- Usuario

```
# Classe Usuario
    A resposbilidade da classe se destina em:
```
```
# Classe Conexao
    A resposbilidade da classe se destina em conectar, fechar e retornar erros com a conexão do banco de dados.
    No caso, sua utilização é justificada para reaproveitamento de código.
    Sua implementação ocorre por composição em outras classes.
```
<details>
    <summary>Explicação detalhada de código.</summary>
    Explicações:

    ```php
    // Será implementado.
    ```
    
</details>

## 2. Processo Dashboard

O processo de dashboard envolve:

- Carregamento de informação do usuário logado (ctr_login.php)
- Classe Dashboard para filtros e dados de reotrno do banco.
- Classe paginação para criar a paginação na tela.
- Controller para centralizar as lógicas acima (incluindo verificação de sessão).

Diagrama de Fluxo Geral
<details>
    <summary>Visualizar diagrama.</summary>
    <h3>Diagrama de Fluxo de Dashboard</h3> 
    <img src="./assets/dashboard_fluxo_geral.png" alt="Fluxo Geral de Dashboard"><br><br>

</details>

Classes e arquivos utilizados no processo:
- Dashboard
- Paginação
- Arquivo Session_Check

```
# Classe Dashboard
    A resposbilidade da classe se destina em:
```
```
# Classe Paginação
    A resposbilidade da classe se destina em
```
<details>
    <summary>Explicação detalhada de código.</summary>
    Explicações:

    ```php
    // Será implementado.
    ```
    
</details>

## 3. Processo de Estoque

## 4. Processo de Agendamento

## 5. Processo de Cadastro de Usuário