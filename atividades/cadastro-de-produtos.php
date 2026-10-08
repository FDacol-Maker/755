<?php

$arquivo = "../dados/produtos.json";

// Checa se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    //1 - RECEBER OS DADOS
    $nome = $_POST["nome"];
    $categoria = $_POST["categoria"];
    $marca = $_POST["marca"];
    $preco = $_POST["preco"];
    $quantidade = $_POST["quantidade"];
    $fabricanteNome = $_POST["fabricante_nome"];
    $fabricantePais = $_POST["fabricante_pais"];

    //2 - LER O ARQUIVO JSON
    $conteudo = file_get_contents($arquivo);

    //3 - CONVERTER O JSON PARA ARRAY EM PHP
    $produtos = json_decode($conteudo, true);

    //CASO O ARQUIVO SEJA INVÁLIDO
    if (!is_array($produtos))
    {
        $produtos = [];
    }

    //4 - CRIAR O ARRAY ASSOCIATIVO DO NOVO PROTUDO
    $novoProduto = 
    [
        "nome" => $nome,
        "categoria" => $categoria,
        "marca" => $marca,
        "preco" => $preco,
        "quantidade" => $quantidade,
        "fabricante" => 
        [
            "nome" => $fabricanteNome,
            "pais" => $fabricantePais
        ]

    ];

    //5 - ADICIONAR O PRODUTO AO ARRAY
    $produtos[] = $novoProduto;

    //6- CONVERTER O ARRAY NOVAMENTE PARA JSON
    $json = json_encode
    (
        $produtos,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );

    //7 - SALVAR NO ARQUIVO JSON
    file_put_contents($arquivo, $json);


}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>

    <link rel="stylesheet" href="../cadastro-de-produtos.css">

</head>

<body>

    <h1>CADASTRO DE PRODUTOS</h1>

    <form method ="POST">
        <label>NOME DO PRODUTO:</label>
        <input type="text" name="nome" required>
        <br><br>

        <label>MARCA:</label>
        <input type="text" name="marca" required>
        <br><br>

        <label>PREÇO:</label>
        <input type="number" name="preco" step="0.01" min="0" required>
        <br><br>

        <h2>FABRICANTE:</h2>

        <label>Nome do Fabricante:</label>
        <input type="text" name="fabricante_nome" required>
        <br><br>

        <label>País de Origem:</label>
        <input type="text" name="fabricante_pais" required>
        <br><br>

        <button type="submit">CADASTRAR PRODUTO</button>

    </form>

    <hr>

    <h2>PRODUTOS CADASTRADOS</h2>

    <?php

    //LER OS PRODUTOS ARMAZENADOS
    $conteudo = file_get_contents($arquivo);

    //CONVERTER JSON PARA ARRAY PHP
    $produtos = json_decode($conteudo, true);

    if(!empty($produtos)) 
    {

        $valorTotal = 0;

        foreach ($produtos as $produto)
        {
            echo "<div>";

            echo "<p><strong>Nome:</strong> ". htmlspecialchars($produto["nome"]). "</p>";
            echo "<p><strong>Categoria:</strong> ". htmlspecialchars($produto["categoria"]). "</p>";
            echo "<p><strong>Marca:</strong> ". htmlspecialchars($produto["marca"]). "</p>";
            echo "<p><strong>Preço:</strong>" . htmlspecialchars($produto["preco"], 2, ",","."). "</p>";
            echo "<p><strong>Quantidade:</strong>" . htmlspecialchars ($produto["quantidade"]) . "</p>";

            echo "<p><strong>Fabricante:</strong>" . htmlspecialchars($produto["fabricante"]["nome"]) . "</p>";

            //DESAFIO EXTRA
            $valorTotal += $produto["preco"] * $produto["quantidade"];

            echo "<p><strong>Valor total em estoque:</strong> R$". number_format($valorTotal,2,",","."). "</p>";

            echo "<hr>";
            echo "</div>";
            
        }
    }   else
    {
        echo "<p>Nenhum produto cadastrado.</p>";
    }
    ?>

</body>
</html>