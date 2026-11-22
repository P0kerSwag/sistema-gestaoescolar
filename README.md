# Educa · Gestão Escolar

Aplicativo mobile-first em PHP, HTML, CSS e JavaScript puro. Não utiliza frameworks nem bibliotecas de terceiros. A tela foi organizada com quatro áreas principais: Visão geral, Alunos, Turmas e Notas e frequência. A navegação vira uma barra inferior no celular; formulários aparecem em diálogos com erros junto ao campo que precisa de correção. As fontes usam opções locais do sistema para evitar dependência externa.

## Executar no XAMPP

1. Mantenha a pasta em `C:\xampp\htdocs\sistema-escolar`.
2. Inicie o Apache no painel do XAMPP.
3. Abra `http://localhost/sistema-escolar/`.
4. Para abrir em um celular conectado à mesma rede, use `http://IP-DO-COMPUTADOR/sistema-escolar/` com o firewall permitindo o Apache. A experiência e os formulários se adaptam à largura do dispositivo.

O app funciona também com `php -S localhost:8000` executado nesta pasta. Para testar instalação PWA e cache offline no computador, use `http://localhost` (service workers exigem localhost ou HTTPS). O navegador do dispositivo conserva os dados no próprio armazenamento local; a API PHP mantém uma cópia no arquivo `data/escola.json` quando a conexão com o servidor está disponível. A API somente é sincronizada quando se altera um registro no app. Primeiro carregamento vazio pode usar os dados de demonstração embutidos.

## Funcionalidades

- Criar, consultar, editar e excluir alunos, turmas e lançamentos acadêmicos.
- Registrar nota (0–10), frequência (0–100%), disciplina, período e data por aluno.
- Consultar perfil acadêmico do estudante, média individual e frequência.
- Visão geral com indicadores, distribuição de desempenho, alunos que precisam de atenção e cadastros recentes.
- Busca e filtro por turma nas listagens; atualização imediata após cada operação.
- Validação de obrigatoriedade, e-mail, duplicidade de e-mail, telefone, data futura, faixa da nota e faixa da frequência.
- Armazenamento local com `localStorage`, cache offline com service worker e cópia opcional no PHP.

## Roteiro de demonstração e registro de testes

1. Abra o endereço acima em um celular ou emule a largura móvel no navegador. Na tela inicial, veja os quatro indicadores e a navegação inferior.
2. Entre em **Alunos → Novo aluno**, tente salvar vazio e verifique as mensagens obrigatórias. Teste e-mail malformado e nota 11 no formulário acadêmico para confirmar as validações.
3. Cadastre um aluno válido e confirme que aparece na lista e no indicador. Abra seu perfil para consultar notas e frequência.
4. Edite o aluno pela ação de lápis; confirme a atualização imediata. Exclua pela ação × e confirme na caixa de diálogo; os lançamentos desse aluno também são removidos.
5. Cadastre uma turma e um lançamento de nota/frequência; pesquise e filtre os registros. Edite e exclua um lançamento.
6. Com o servidor aberto, faça uma alteração online para gravar `data/escola.json`. Recarregue a página, desligue a rede e recarregue novamente para observar a cópia local/cache; a API PHP não fica disponível sem o servidor.
7. Feche e reabra o navegador/app no mesmo dispositivo: os dados do navegador permanecem no `localStorage`.

| Verificação | Resultado esperado |
| --- | --- |
| Campos obrigatórios vazios | Bloqueia o salvamento e destaca os campos vazios |
| E-mail inválido ou duplicado | Mostra erro no campo e não salva |
| Nota fora de 0–10 / frequência fora de 0–100 | Bloqueia e informa a faixa aceita |
| Data futura / telefone incompleto | Bloqueia e indica o ajuste necessário |
| Criar, editar e excluir | Lista e indicadores atualizam imediatamente |
| Fechar e reabrir navegador | Dados persistem no mesmo perfil/dispositivo |
| Sem Internet | Interface e dados locais continuam disponíveis; API server-side aguarda conexão |

### Verificações executadas durante a implementação

- `php -l index.php` e `php -l api.php`: sem erros de sintaxe.
- `node --check app.js`: sem erros de sintaxe.
- `node --test tests/validation.test.js`: 5 verificações passaram (campo vazio, e-mail inválido, nota fora da faixa, frequência no limite e telefone inválido).
- API PHP em servidor local: a página e a gravação/leitura JSON foram verificadas; payload inválido retornou HTTP 400. O arquivo de teste foi removido após a verificação.
- A primeira tentativa de leitura HTTP do PowerShell falhou por configuração do parser legado do Internet Explorer; a chamada da API continuou e a gravação/leitura foi aprovada. Uma nova leitura da página deve usar `Invoke-WebRequest -UseBasicParsing`.
- A inspeção da interface no Chrome e a execução em aparelho físico não foram realizadas: o controle do Chrome foi recusado pelo ambiente. Use o roteiro acima para demonstrar os fluxos no dispositivo da aula.

Este repositório contém a aplicação e o roteiro verificável. A demonstração física em um aparelho requer abrir o endereço no dispositivo; ela não pode ser alegada como já executada aqui.
