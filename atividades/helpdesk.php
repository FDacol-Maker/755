<?php
require_once "helpdesk-func.php";

//Processa as ações enviadas pelos formulários
if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    $acao = $_POST["acao"];

        if ($acao == "cadastrar") 
        {
            $nome = $_POST["nome"];
            $setor = $_POST["setor"];
            $equipamento = $_POST["equipamento"];
            $descricao = $_POST["descricao"];
            $prioridade = $_POST["prioridade"];

            cadastrarChamado($nome, $setor, $equipamento, $descricao, $prioridade);

            header("Location: helpdesk.php");
            exit;
        }

        if ($acao == "atualizar") 
        {
            $index = $_POST["index"];
            $status = $_POST["status"];

            atualizarStatusChamado($index, $status);

            header("Location: helpdesk.php");
            exit;
        }

        if ($acao == "excluir")
        {
            $index = $_POST["index"];

            excluirChamado($index);
            header("Location: helpdesk.php");
            exit;
        }
}

//RECUPERA OS DADOS E GERA OS TOTAIS DO RELATÓRIO
$chamados = lerChamados();
$totalGeral = count($chamados);
$totalAbertos = contarStatus("Aberto");
$totalAndamento = contarStatus("Em andamento");
$totalResolvidos = contarStatus("Resolvido");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>


    <h1>GERENCIAMENTO DE CHAMADOS</h1>

    <!-- PAINEL DE RELATÓRIO EXIGIDO NA ATIVIDADE -->
     <div class = "relatorio">
     <div class="card" ><strong>Total Geral:</strong> <?php echo $totalGeral; ?></div>
     <div class="card" ><strong>Abertos: </strong> <?php echo $totalAbertos; ?></div>
     <div class="card"><strong>Em Andamento: </strong> <?php echo $totalAndamento; ?></div>
     <div class="card"><strong>Resolvidos:</strong> <?php echo $totalResolvidos; ?></div>

     </div>

     <!-- FORMULÁRIO DE CADASTRO -->
      <form method="POST">
        <input type="hidden" name="acao" value="cadastrar">

        <label>NOME DO SOLICITANTE:</label>
        <input type="text" name="nome" required>
        <br><br>

        <label>SETOR DA EMPRESA:</label>
        <select name="setor">
            <option value="Produção">Produção</option>
            <option value="Administrativo">Administrativo</option>
            <option value="Logística">Logística</option>
            <option value="Financeiro">Financeiro</option>
            <option value="TI">TI</option>
        </select>
        <br><br>

        <label>EQUIPAMENTO AFETADO:</label>
        <select name="equipamento">
            <option value="Computador">Computador</option>
            <option value="Impressora">Impressora</option>
            <option value="Rede">Rede</option>
            <option value="Sistema">Sistema</option>
            <option value="Outro">Outro</option>
        </select>
        <br><br>

        <label>DESCRIÇÃO DO PROBLEMA:</label>
        <textarea name="descricao" rows="3" required></textarea>
        <br><br>

        <label>PRIORIDADE:</label>
        <select name="prioridade">
            <option value="Baixa">Baixa</option>
            <option value="Média">Média</option>
            <option value="Alta">Alta</option>
        </select>
        <br><br>

        <button type="submit">REGISTRAR CHAMADO</button>
      </form>

      <hr>

      <h2>CHAMADOS REGISTRADOS</h2>

      <table>
        <thead>
            <tr>
                <th>Nº</th>
                <th>Solicitante</th>
                <th>Equipamento</th>
                <th>Descrição</th>
                <th>Prioridade</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php

            if (!empty($chamados)) 
            {
                foreach ($chamados as $index => $chamado)
                {
                    echo "<tr>";
                    echo "<td>" . $index ."</td>";
                    echo "<td>" . htmlspecialchars ($chamado["nome"]). "(" .$chamado["setor"] .")</td>";
                    echo "<td>" . $chamado["equipamento"] ."</td>";
                    echo "<td>" . htmlspecialchars($chamado["descricao"]) . "</td>";
                    echo "<td>" . $chamado["prioridade"] . "</td>";

                    //COLUNA COM SELECT PRA ATUALIZAR O STATUSf
                    echo "<td>";
                    echo "<form method='POST' class='inline-form'>";
                    echo"<input type='hidden' name='acao' value'atualizar'>" . $index . "'>";
                    echo "<input type='hidden' name='index' value='" . $index . "'>";
                    echo "<select name='status'>";

                    //CONDICIONAIS PARA MARCAR O ITEM SELECIONADO
                    if ($chamado["status"] == "Aberto") { echo "<option value='Aberto' selected>Aberto</option>"; } else { echo "<option value='Aberto'>Aberto</option>"; }
                    if ($chamado["status"] == "Em andamento") { echo "<option value='Em andamento' selected>Em andamento</option>"; } else { echo "<option value='Em andamento'>Em andamento</option>"; }
                    if ($chamado["status"] == "Resolvido") { echo "<option value='Resolvido' selected>Resolvido</option>"; } else { echo "<option value='Resolvido'>Resolvido</option>"; }
                    

                    echo "</select>";
                    echo "<button type='submit' class='btn=atualizar' style='width: auto; padding: 5px 10px; margin-left: 5px; font-size: 12px;'>OK</button>"; 
                    echo "</form>";
                    echo "</td>";

                    //COLUNA COM BOTÃO PARA EXCLUIR CHAMADO
                    echo "<td>";
                    echo "<form method='POST' class='inline-form'>";
                    echo "<input type='hidden' name='acao' value='excluir'>";
                    echo"<input type='hidden' name='index' value='" .$index . "'>";
                    echo"<button type='submit' class='btn-excluir'>Excluir</button>";
                    echo"</form>";
                    echo"</td>";

                    echo "</tr>";
                }
            } 
            else 
            {
                echo "<tr><td colspan='7' style='text-align: center;'>Nenhum chamado registrado.</td></tr>";
            }

            ?>

        </tbody>
      </table>
</body>
</html>
