<?php

// PHP: Linguagem que executa as regras do sistema.
// MY SQL: SGBD (Sistema gerenciador de banco de dados)
// PDO: Interface do PHP que permite conversar com o banco


// host = "locahost"
$host = '194.61.238.119(localhost)';
$db = 'francisco755db1';
$user = 'francisco755';
$pass = '755!@#';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset",
    $user,
    $pass
    );

    $pdo->setAttribute(

        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION 
    );

    echo "Conectado com sucesso!";




    
} catch (PDOException $e) {
    echo "ERRO AO CONECTAR AO BANCO DE DADOS:\n";
    echo $e->getMessage();


}