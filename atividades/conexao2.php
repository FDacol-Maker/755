<?php
$host = 'localost';
$dbname = 'loja_informatica';
$username = 'root';
$password = '';

try
{
    $pdo = new PDO("myswl:host=$host;charset=utf8", $username, $password);
    $pdo-> setAttibute(PDO:: ATTR_ERRMODE,PDO:: ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABATE IF IT NOT EXISTS loja_informatica");
    $pdo->("Use loja_informatica");
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit;
}

?>