<?php
    require_once "funcoes.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $nota1 = $_POST["nota1"];
        $nota2 = $_POST["nota2"];

        $media = calcularMedia($nota1, $nota2);
        $situacao = verificarStatus($media);

    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funções no front</title>
</head>
<body>
    
    <h1><?= $nomeEscola ?></h1>
    <h2><?= saudacao() ?></h2>
    <p><?= cumprimentar("Lucas") ?>
    </p>
    <p>
        Resultado da soma:
        <?=  somar(10, 5) ?>
    </p>

</body>
</html>