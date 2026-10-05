<?php

$caminhoArquivo = 'dados/produtos.json';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $marca = $_POST['marca'] ?? '';
    $preco = (float) ($_POST['preco'] ?? 0);
    $quantidade = (int) ($_POST['quantidade'] ?? 0);
    $fabricanteNome = $_POST['fabricante_nome'] ?? '';
    $fabricantePais = $_POST['fabricante_pais'] ?? '';

    if (!empty($nome) && !empty($categoria) && !empty($marca) && $preco > 0 && $quantidade >= 0) {

        $novoProduto =
            [
                'nome' => $nome,
                'categoria' => $categoria,
                'marca' => $marca,
                'preco' => $preco,
                'quantidade' => $quantidade,
                'fabricante' =>
                [
                    'nome' => $fabricanteNome,
                    'pais' => $fabricantePais
                ]
            ];

        $conteudoJson = file_get_contents($caminhoArquivo);

        $produtos = json_decode($conteudoJson, true);

        if (!is_array($produtos)) {
            $produtos = [];
        }

        $produtos[] = $novoProduto;

        $jsonAtualizado = json_encode($produtos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        file_put_contents($caminhoArquivo, $jsonAtualizado);

        $mensagem = "Produto cadastrado com sucesso!";
    } else {
        $mensagem = "Por favor, preencha todos os campos corretamente.";
    }
}

$conteudoJson = file_get_contents($caminhoArquivo);
$produtosCadastrados = json_decode($conteudoJson, true) ?? [];

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <titte>Cadastro de Produtos</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 30px;
                background-color: #f4f4f9;
            }

            .container {
                max-width: 650px;
                margin: auto;
                background: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h1,
            h2 {
                color: #333;
                text-align: center;
            }

            .form-group {
                margin-bottom: 15px;
            }

            label {
                display: block;
                font-weight: bold;
                margin-bottom: 5px;
            }

            input[type="text"],
            input[type="number"] {
                width: 100%;
                padding: 8px;
                box-sizing: border-box;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            fieldset {
                border: 1px solid #ddd;
                padding: 15px;
                margin-bottom: 15px;
                border-radius: 4px;
            }

            legend {
                font-weight: bold;
                padding: 0 5px;
            }

            button {
                width: 100%;
                padding: 10px;
                background-color: #28a745;
                color: white;
                border: none;
                border-radius: 4px;
                font-size: 16px;
                cursor: pointer
            }

            button:hover {
                background-color: 218838;
            }

            .mensagem {
                background: #e2e3e5;
                padding: 10px;
                border-radius: 4px;
                margin-bottom: 20px;
                text-align: center;
                font-weight: bold;
            }

            .card-produto {
                border: 1px solid #ccc;
                background: #fafafa;
                padding: 15px;
                margin-bottom: 15px;
                border-radius: 6px;
            }

            .card-produto h3 {
                margin-top: 0;
                color: #007bff;
            }

            .total-estoque {
                font-weight: bold;
                color: #d9534f;
            }
        </style>
</head>

<body>

    <div class="container">
        <h1>Cadastro de Protudo</h1>

        <?php if (!empty($mensagem)) : ?>
            <div class="mensagem"><?= htmlspecialchars($mensagem) ?></div>
        <?php endif; ?>

        <!--- Formulário de Cadastro --->
        <form action="" method="POST">
            <div class="form-group">
                <label for="nome">Nome do Produto:</label>
                <input type="text" id="nome" name="nome" required>
            </div>

            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" required>
            </div>

            <div class="form-group">
                <label for="preco">Preço (R$): </label>
                <input type="number" id="preco" name="preco" step="0.01" min="0.01" required>
            </div>

            <!--- Dados do Fabricante --->
            <fieldset>
                <legend>Informações do Fabricante</legend>
                <div class="form-group">
                    <label for="fabricante_nome">Nome do Fabricante:</label>
                    <input type="text" id="fabricante_nome" name="fabricante_nome" required>
                </div>

                <div class="form-group">
                    <label for="fabricante_pais">País de Origem:</label>
                    <input type="text" id="fabricante_pais" name="fabricante_pais" required>
                </div>
            </fieldset>

            <button type="submit">Cadastrar Protudo</button>
        </form>

        <hr style="margin: 30px 0;">

        <!--- Seção de Exibição dos Produtos --->
        <h2>PRODUTOS CADASTRADOS</h2>

        <?php if (empty($produtosCadastrados)): ?>
            <p style="text-align:  center;">Nenhum produto cadastrado ainda.</p>
        <?php else: ?>
            <?php foreach ($produtosCadastrados as $produto): ?>
                <?php

                // DESAFIO EXTRA: Cálculo do valor total em estoque
                $valorTotalEstoque = $produto['preco'] * $produto['quantidade'];
                ?>
                <div class="card-produto">
                    <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                    <p><strong>Categoria:</strong> <?= htmlspecialchars($produto['categoria']) ?></p>
                    <p><strong>Marca:</strong> <?= htmlspecialchars($produto['marca']) ?></p>
                    <p><strong>Preço Unitário:</strong> R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                    <p><strong>Quantidade em Estoque:</strong> <?= $produto['quantidade'] ?></p>

                    <p><strong>Fabricante:</strong> <?= htmlspecialchars($produto['fabricante']['nome']) ?> (<?= htmlspecialchars($produto['fabricante']['pais']) ?>)</p>

                    <!--- Exibição do Desafio Extra --->
                    <p class="total-estoque">
                        Valor total em estoque: R$ <?= number_format($valorTotalEstoque, 2, ',', '.') ?>
                    </p>

                </div>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>

</body>

</html>