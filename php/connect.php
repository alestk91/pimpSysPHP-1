<?php

function connect()
{
    $host = ''; //hostname
    $user = '';
    $pw = '';
    $schema = ''; //$$db
    $con = '';

    $con = mysqli_connect($host, $user, $pw, $schema) or die('Falha ao conectar ao banco de dados');
    return $con;
}
?>
