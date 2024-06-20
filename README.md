Descrição
Este é um sistema de gestão simples desenvolvido em PHP utilizando PDO para a conexão com o banco de dados MySQL. O sistema permite o controle de estoque, receitas e despesas, além de gerar relatórios em XML e CSV.

Funcionalidades
Cadastro e login de usuários.
Adição, edição e remoção de produtos no estoque.
Adição, edição e remoção de despesas e receitas.
Geração de relatórios em XML e CSV.
Cálculo e exibição do balanço financeiro.
Requisitos
PHP 7.4 ou superior
MySQL 5.7 ou superior
Servidor Apache (XAMPP recomendado)
Instalação
Clone o repositório para o seu diretório de servidor web (htdocs para XAMPP):


Crie o banco de dados no MySQL:

sql
Copiar código
CREATE DATABASE sistema_estoque;
USE sistema_estoque;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto VARCHAR(255) NOT NULL,
    quantidade INT NOT NULL,
    data DATE NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES usuarios(id),
    UNIQUE (produto, user_id)
);

CREATE TABLE despesas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES usuarios(id)
);

CREATE TABLE receitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES usuarios(id)
);
Configure o arquivo de conexão com o banco de dados em includes/db.php:

php
Copiar código
<?php
$host = '127.0.0.1';
$db = 'sistema_estoque';
$user = 'seu_usuario';
$pass = 'sua_senha';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\\PDOException $e) {
    throw new \\PDOException($e->getMessage(), (int)$e->getCode());
}
?>
Inicie o servidor Apache e acesse o sistema no navegador:



Estrutura de Diretórios
css
Copiar código
sistema_gestao/
├── 
includes/

│   ├── db.php

│   ├── header.php

│   └── footer.php
├──
views/

│   ├── adicionar_despesa.php

│   ├── editar_despesa.php

│   ├── editar_receita.php

│  
├── adicionar_estoque.php
│  
├── editar_estoque.php
│  
├── estoque.php
│   
├── despesas_receitas.php
│  
├── xml_relatorios.php
│  
├── precificacao.php

├── register.php

├── login.php

├── logout.php

├── index.php

Funcionalidades Detalhadas
Cadastro e Login

register.php: Permite o cadastro de novos usuários.

login.php: Permite o login de usuários cadastrados.

logout.php: Efetua o logout do usuário.

Controle de Estoque

adicionar_estoque.php: Adiciona produtos ao estoque.

editar_estoque.php: Edita informações de produtos no estoque.

estoque.php: Lista os produtos no estoque, permitindo editar ou remover produtos.

Controle de Despesas e Receitas

adicionar_despesa.php: Adiciona uma nova despesa.

editar_despesa.php: Edita uma despesa existente.

adicionar_receita.php: Adiciona uma nova receita.

editar_receita.php: Edita uma receita existente.

despesas_receitas.php: Lista todas as despesas e receitas, permitindo editar cada uma.
Geração de Relatórios

xml_relatorios.php: Gera relatórios em XML e CSV com base no período selecionado pelo usuário.
Precificação de Mercadorias

precificacao.php: Calcula o preço de venda de uma mercadoria com base no preço de compra e na margem de lucro.
