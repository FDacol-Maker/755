<?php
$arquivo = __DIR__ . "/../dados/chamados.json";
 
function lerChamados(){
    global $arquivo;
    if(!file_exists($arquivo)) 
    {
        return[];
    }

    $conteudo = file_get_contents($arquivo);
    $chamados = json_decode($conteudo, true);

    if (!is_array($chamados)) {
        $chamados = [];
    }
    return $chamados;
}

function salvarChamados($chamados) {
    global $arquivo;
    $json = json_encode(array_values($chamados), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents($arquivo, $json);
}   

function cadastrarChamado($nome, $setor, $equipamento, $descricao, $prioridade)
{
    if(empty($nome) || empty($descricao)) return; // Validação básica

    $chamados = lerChamados(); //Carrega a lista antes de adicionar novamente


    $chamados[] = 
    [
        "nome"=> $nome,
        "setor" => $setor,
        "equipamento" => $equipamento,
        "descricao" => $descricao,
        "prioridade" => $prioridade,
        "status" => "Aberto"
    ];
    salvarChamados($chamados);
}

function atualizarStatusChamado($index, $novoStatus)
{
    $chamados = lerChamados();
    if ($chamados[$index] == true) 
    {
        $chamados[$index]['status'] = $novoStatus;
        salvarChamados($chamados);
    }
}

function excluirChamado($index){
    $chamados = lerChamados();
    if ($chamados[$index] == true)
    {
        unset($chamados[$index]);
        salvarChamados($chamados);
    }
}

function contarStatus($status)
{
    $chamados = lerChamados();
    $total = 0;
    foreach ($chamados as $c)
    {
        if ($c['status'] == $status) 
        {
        $total++;
        }
    }
    return $total;
}