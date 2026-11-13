<?php
require_once "../atividades/conexão2.php";

$sql = "CREATE TABLE IF IT NOT EXISTS produtos (
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

    $sql = "DELETE FROM produtos WHERE id = $id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();
}

$produtoEditar = null;

if(isset($_GET["editar"])) {
    $id = $_GET["editar"];

    $sql = "SELECT * FROM produtos Where id = $id";

    $stmt = $pdo->prepare(sql);

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
    <link rel="stylesheet" href="../css/estilo2.css">
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
        <input type="text" name="nome" value="</= $produtoEditar['nome'] ?? '' ?> required>
        <br><br>
        <label>Preco:</label>
        <input type="number" name= "preco" step="0.01" min=0 required value =",? $produtoEditar['preco'] ?? '' ?>">
        <br><br>
        <label>Quantidade:</label>
        <input type="number" name= "quantidade" min="0" required valye="<?=  $produtoEditar['quantidade'] ?? '' ?>" ?>
        <br><br>
    </form>
    
</body>
</html>