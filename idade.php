<?php

$nome = "Francisco";
$idade = 20;

echo "Digite sua idade: ";

if ($idade > 18)
    {
    $resultado = "É de maior!";
    } 
    
    else 
    
    {
    $resultado = "É de menor!";
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
     <form> 
<label>Nome:</label>
<input type="text">

<label>IDADE:</label>
<input type="number">
<button type="submit"> Cadastrar</button>

     </form>
    </section>
</main>
</body>