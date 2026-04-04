Seguinte, a pasta datafiles não existe no projeto. Eu adicionei ela só pra que vocês tivessem uma base.

Então vamos lá: 
- O artistar.sql tem toda a estrutura de banco de dados que vcs vão precisar. 
- O banco de dados é MySQL/MariaDB, e a versão do PhP que eu estou usando é a 8, baixem o xampp pra poderem desenvolver
- Configurem um virtualhost ou até mesmo a raiz do servidor direto pra pasta do projeto
- Fora da pasta do projeto, criem a pasta setup (também está no datafiles) com o default.json
- O default.json tem todas as credenciais que vocês vão precisar
- TOMEM EXTREMO CUIDADO, NÃO DIVULGUEM ESSAS CREDENCIAIS COM NINGUEM
- Se forem criar uma pasta de arquivos temporários, na mesma camada onde fica a pasta do projeto e a setup, crie uma chamada "database".
- Se alguma parte da aplicação precisar salvar arquivos no servidor, usem a database
- Qualquer coisa me chama

Estrutura do projeto:


- setup
- database
- artistar (aponte a raiz do servidor para cá, seja por virtualhost ou DocumentRoot direto)