<?php

// PHP: Linguagem que executa as regras do sistema.
// MY SQL: SGBD (Sistema gerenciador de banco de dados)
// PDO: Interface do PHP que permite conversar com o banco


// host = "locahost"
$host = 'localhost';
$db = 'francisco755_db1';
$user = 'francisco755';
$pass = '755!@#';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset",$user,$pass);

    $pdo->setAttribute(

        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION 
    );
    
} catch (PDOException $e) {
    echo "ERRO AO CONECTAR AO BANCO DE DADOS:\n";
    echo $e->getMessage();


}

$sql = "CREATE TABLE IF NOT EXISTS produtos (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100) NOT NULL,
preco DECIMAL(10, 2) NOT NULL,
quantidade INT NOT NULL)";

$pdo->exec($sql);

if (isset($_POST["cadastrar"])){
    $nome = $_POST["nome"];
    $preco = $_POST["preco"];
    $quantidade = $_POST["quantidade"];

    $sql = "INSERT INTO produtos(nome, preco, quantidade) VALUES ('$nome', $preco, $quantidade)"; 

    $stmt = $pdo->prepare($sql);

    $stmt->execute();
}

if (isset($_POST["atualizar"])){
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $preco = $_POST["preco"];
    $quantidade = $_POST["quantidade"];

    $sql = "UPDATE produtos SET nome = '$nome' , preco = $preco, quantidade = $quantidade WHERE id = $id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();
}

if (isset($_POST["excluir"])) {
    $id = $_POST["id"];

    $vendas_check = $pdo->query("SELECT COUNT(*) FROM vendas WHERE produto_id = $id")->fetchColumn();
    if ($vendas_check > 0) {
        $mensagem = "Erro: Este produto possui vendas registradas e não pode ser excluido!";    
    } else {
    $sql = "DELETE FROM produtos WHERE id = $id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();
    $mensagem = "Produto excluído com sucesso!";
}

if (isset($_POST["vender"])) {
    $produto_id = $_POST["produto_id"];
    $qtd_vendida = $_POST["quantidade_venda"];

    $prod = $pdo->query("SELECT FROM produtos WHERE id =$produto_id")->fetch(PDO::FETCH_ASSOC);

    if($qtd_vendida <= 0){
        $mensagem = "A quantidade deve ser maior que zero!";
    } elseif ($qtd_vendida > $prod['quantidade']) {
        $mensagem = "Estoque insuficiente! Disponível: " . $prod['quantidade'];
    } else {
        $valor_total = $prod['preco'] * $qtd_vendida;
        $novo_estoque = $prod['quantidade'] - $qtd_vendida;

        $pdo->exec("INSERT INTO vendas (produto_id, quantidade, valor_total, data_venda) VALUES ($produto_id, $qtd_vendida, $valor_total,'$data_venda')");
        $pdo->exec("UPDATE produtos SET quantidade = $novo_estoque WHERE id = $produto_id");

        $mensagem = "Venda realizada com sucesso! Total: R$ " . number_format($valor_total, 2, '.','.');
    }
}

$produtoEditar = null;

if(isset($_GET["editar"])) {
    $id = $_GET["editar"];

    $sql = "SELECT * FROM produtos Where id = $id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    $produtoEditar = $stmt->fetch(PDO::FETCH_ASSOC);
}

$sql = "SELECT * FROM produtos ORDER BY id ASC";

$stmt = $pdo->query($sql);

$produtos = $stmt->fetchALL(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/../css/estilo2.css">
</head>
<body>
    <h1>Sistema de Cadastro de Produtos</h1>
    <h2>
        <?php
        if ($produtoEditar) {
            echo "Editar produto";
        }
        else {
            echo "Cadastrar produto";
        }
        ?>
    </h2>
    
    <form method="POST">
        <?php if ($produtoEditar) { ?>
        <input type="hidden" name="id" value ="<?=  $produtoEditar['id'] ?>">
        <?php } ?>    

        <label>Nome do Produto:</label>
        <input type="text" name="nome" value="<?= $produtoEditar['nome'] ?? '' ?> "> <required>
        <br><br>

        <label>Preco:</label>
        <input type="number" name= "preco" step="0.01" min=0 required value ="<?= $produtoEditar['preco'] ?? '' ?>">
        <br><br>
        <label>Quantidade:</label>
        <input type="number" name= "quantidade" min="0" required value="<?=  $produtoEditar['quantidade'] ?? '' ?>">
        <br><br>

        <?php if ($produtoEditar) { ?>
            <button type="submit" name ="atualizar">Atualizar Produto</button>
        <?php } else {?>
        <button type="subtmit" name="cadastrar">Cadastrar Produto</button>
        <?php } ?>
    </form>
    <hr>

    <h2>Registrar Venda</h2>
    <form method="POST">
        <label>Selecione o Produto:</label>
        <select name="produto_id" required>
            <?php foreach ($produtos as $p) { if ($p['quantidade'] > 0) { ?>
            <option value="<? $p['id'] ?>"><?=  $p['nome'] ?> (Estoque: <?=  $p['quantidade'] ?>)</option>
            <?php }} ?>

        </select>
        <br><br>
        <label>Quantidade a Vender:</label>
        <input type="number" name="quantidade_venda" min="1" value="1" required>
        <br><br>
        <button type = "submit" name="vender">Finalizar venda</button>
    </form>
    <hr>

    <h2>Produtos Cadastrados</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($produtos as $produto) { ?>
            <tr>
                <td><?=  $produto["id"] ?></td>
                <td><?=  htmlspecialchars($produto["nome"]) ?></td>
                <td> R$ <?=  number_format($produto["preco"], 2, ",", ".") ?></td>
                <td> <?=  $produto["quantidade"] ?></td>
                <td>
                    <a href="db2.php?editar=<? $produto['id'] ?>">Editar</a>
                    <form method="POST" action="db2.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?=  $produto['id'] ?>">
                        <button type="submit" name="excluir" onclick="return confirm('Deseja excluir esse produto?')">Excluir</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
    </table>
    <hr>

    <h2>Histórico de Vendas</h2>
    <table>
        <tr>
            <th>ID Venda</th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Valor Total</th>
            <th>Data</th>
        </tr>
        <?php foreach ($vendas as $v) { ?>
        <tr>
            <td><?=  $v["id"] ?></td>
            <td><?=  htmlspecialchars($v["produto_nome"]) ?></td>
            <td><?=  $v["quantidade"] ?></td>
            <td>R$ <?=  number_format($v["valor_total"], 2, ",", ".") ?></td>
            <td><?=  date('d/m/y H:i:s', strtotime($v["data_venda"])) ?></td>
        </tr>  
        <?php } if(empty($vendas)) { ?>
        <tr><td colspan="5">Nenhuma venda registrada ainda.</td></tr>
        <?php } ?>
    </table>
    
</body>
</html>