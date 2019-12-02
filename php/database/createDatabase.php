<?php
require('/Projeto/dev_php/pimpSysPHP/php/connect.php');

         if(! $con ) {
            die('Could not connect: ' . mysql_error());
         }

         echo 'Connected successfully<br />';
         $sql = 'CREATE DATABASE PRODUCTS'; // recebe o nome da variavel do banco a ser criado
         $retval = mysql_query( $sql, $conn );
      
         if(! $retval ) {
            die('Could not create database: ' . mysql_error());
         }

         echo "Database PRODUCTS created successfully\n";
         mysql_close($conn);
?>