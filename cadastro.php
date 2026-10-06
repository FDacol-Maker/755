<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produto</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f4f9; }
        nav { background: #333; padding: 10px; margin-bottom: 20px; border-radius: 4px; }
        nav a { color: white; margin-right: 15px; text-decoration: none; font-weight: bold; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="number"] { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        fieldset { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 4px; }
        legend { font-weight: bold; padding: 0 5px; }
        button { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        button:hover { background-color: #218838; }
    </style>
</head>
<body>

<header>
    <nav>
        <a href="idade.php">Início</a>
        <a href="cadastro.html">Cadastro</a>
        <a href="cadastrar.php">Ver Produtos</a>
    </nav>
</header>

<div class="container">
    <h1>Cadastrar Produto</h1>

    <!-- O formulário envia os dados para o arquivo cadastrar.php -->
    <form action="cadastrar.php" method="POST">
        <div class="form-group">
            <label for="nome">Nome do Produto:</label>
            <input type="text" id="nome" name="nome" required>
        </div>

        <div class="form-group">
            <label for="categoria">Categoria:</label>
            <input type="text" id="categoria" name="categoria" required>
        </div>

        <div class="form-group">
            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" required>
        </div>

        <div class="form-group">
            <label for="preco">Preço (R$):</label>
            <input type="number" id="preco" name="preco" step="0.01" min="0.01" required>
        </div>

        <div class="form-group">
            <label for="quantidade">Quantidade em Estoque:</label>
            <input type="number" id="quantidade" name="quantidade" min="0" required>
        </div>

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

        <button type="submit">Cadastrar Produto</button>
    </form>
</div>

</body>
</html>