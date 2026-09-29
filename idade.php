<?php

$nome = $_POST["nome"];
$idade = $_POST["idade"];

echo "Digite sua idade: ";

if ($idade > 18) {
    echo $resultado = "É de maior!";
} else {
    echo $resultado = "É de menor!";
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<body>
    <header>
        <nav>
            <a href="idade.php">inicio </a>
            <a hrep="cadastro.html">CADASTROS </a>
        </nav>
    </header>
</body>
<main>
    <section class="Cadastro">
        <h1>cadastro</h1>
        <form method="POST">

            <label>Nome:</label>
            <input type="text" class="nome" id="nome" name="nome">

            <label>IDADE:</label>
            <input type="number" class="idade" id="idade" name="idade">
            <button type="submit"> Cadastrar</button>


        </form>
    </section>
</main>
</body>