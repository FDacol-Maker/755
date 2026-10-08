<?php

$nomeEscola = "SENAI";

function saudacao()
{
    return "Bem vindo ao sistema!";
}

function cumprimentar($nome)
{
return "Olá, " . $nome . "!";
}

function somar($numero1, $numero2)
{
    $resultado = $numero1 + $numero2;
    return $resultado;
}

function calcularMedia($nota1, $nota2)
{
    $media = ($nota1 = $nota2);
    return $media;
}

function verificarStatus($media)
{
    //MÉDIA É 7
    if($media >= 7)
        {
            echo "APROVADO";
        }
        else{
            echo "REPROVADO";
        };
}



?>