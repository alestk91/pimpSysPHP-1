<?php
    $host = 'localhost';
    $user = 'root';
    $pw = '';
    $schema = 'pimpsys';

    $con = mysqli_connect($host, $user, $pw, $schema) or die('Falha ao conectar ao banco de dados');
?>