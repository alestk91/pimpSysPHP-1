<?php
    $host = 'localhost'; //hostname
    $user = 'root';
    $pw = '';
    $schema = 'pimpsys'; //$$db

    $con = mysqli_connect($host, $user, $pw, $schema) or die('Falha ao conectar ao banco de dados');
?>
