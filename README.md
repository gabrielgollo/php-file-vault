# file-vault-php
O projeto PHP-File-Vault é um sistema simples de armazenamento de arquivos em disco desenvolvido como parte do trabalho da disciplina de Banco de Dados. 
Para sua implementação, utilizou-se o software XAMPP, que serviu tanto para criar e gerenciar o banco de dados necessário, quanto para executar o projeto localmente.

![](https://github.com/gabrielgollo/php-file-vault/blob/main/ER-file-vault.png)


Após a implementação, o projeto foi versionado em um repositório no GitHub e posteriormente migrado para a plataforma Azure, com o objetivo de disponibilizá-lo na nuvem.

O projeto é composto por três entidades principais: USER, FOLDER e FILE. 

A entidade USER representa os usuários do sistema, com informações como ID, nome de usuário, e-mail e senha. A entidade FOLDER representa as pastas criadas pelos usuários para organizar seus arquivos, contendo informações como ID, nome da pasta e ID da pasta pai. A entidade FILE representa os arquivos armazenados no sistema, com informações como ID, nome do arquivo, tipo de arquivo, tamanho e ID da pasta associada.

A página web do projeto exibe as informações das tabelas USER, FOLDER e FILE, permitindo aos usuários visualizar e gerenciar seus arquivos. Além disso, o sistema possui recursos como upload de arquivos, exclusão de arquivos e pastas, e download de arquivos.

No contexto do projeto, foi criada uma interação entre as entidades USER, FOLDER e FILE, em que cada usuário pode criar pastas para organizar seus arquivos e associar os arquivos a essas pastas. Essa estrutura de relacionamento permite aos usuários organizar e acessar facilmente seus arquivos de acordo com a estrutura de pastas criada.

O PHP-File-Vault é uma solução simples e prática para armazenamento de arquivos em disco, proporcionando aos usuários uma forma eficiente de gerenciar e acessar seus arquivos de maneira organizada.