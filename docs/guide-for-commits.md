# Padrão de Commits

Este documento descreve o padrão de commits que devemos seguir para manter o histórico de mudanças organizado e fácil de entender. Seguir ajudaria a manter um padrão na hora de identificar e discutir mudanças realizadas no projeto.

## Tipos de Commits

- **feat**: Adição de uma nova funcionalidade.
- **fix**: Correção de bugs.
- **docs**: Alterações na documentação.
- **style**: Mudanças de formatação que não afetam a lógica do código (espaços, indentação, etc.).
- **refactor**: Refatoração de código, sem adição de novas funcionalidades ou correção de bugs.
- **test**: Adição ou modificação de testes.
- **chore**: Atualizações de tarefas diversas que não afetam o código em si, como mudanças em configurações ou dependências.

## Estrutura do Commit

1. **Tipo**: O que foi feito (feat, fix, etc.).
2. **Área afetada** (opcional): Qual parte foi modificada.
3. **Descrição curta**: Resumo objetivo do que foi feito.
4. **Corpo do commit** (opcional, para commits mais complexos):
   - Explicação detalhada das mudanças.
   - **O que** foi alterado, **por que** foi necessário e **como** impacta o sistema.
5. **Referência** (opcional): Relacionado a uma tarefa, issue ou pull request.

## Exemplos de Commits Simples

- `feat: add função de cadastro de cliente`
- `fix: corrigir erro na consulta de produtos`
- `docs: atualizar README com instruções de instalação`
- `style: ajustar indentação no arquivo CSS`
- `refactor: refatorar função de cálculo de preços`
- `test: adicionar teste para função de login`
- `chore: atualizar dependências do projeto`

## Exemplo de Commit Complexo

```bash
feat: implementar sistema de login e autenticação

- Adiciona uma nova rota para login no backend.
- Implementa verificação de credenciais no banco de dados MySQL.
- Adiciona middleware para validação de tokens JWT em rotas protegidas.
- Refatora a função de validação de usuários para maior clareza.
- Atualiza a documentação do README com detalhes sobre autenticação.

Essa mudança resolve o problema de segurança e facilita o controle de acesso.
Relacionado à issue #34.
```
