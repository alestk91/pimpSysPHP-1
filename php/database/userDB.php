<?php

require('/Projeto/dev_php/pimpSysPHP/php/connect.php');


function selectUser ($idUser)
{ 
    $con = connect();

    if(! $con ) {
        die('Could not connect: ' . mysql_error());
     }
     $sql = 'SELECT
                _idUser,
                _idCompany,
                login,
                email 
             FROM 
                user 
             WHERE 
                idUser = $idUser';
     mysql_select_db('PIMPSYS');
     $retval = mysql_query( $sql, $con );
     
     if(! $retval ) {
        die('Could not get data: ' . mysql_error());
     }

     echo "Fetched data successfully\n";
     mysql_close($con);

    return $retval;
}

function selectByCompany ($idCompany)
{ 
    $con = connect();

        if(! $con ) {
            die('Could not connect: ' . mysql_error());
        }
        $sql = 'SELECT
                    _idUser,
                    _idCompany,
                    login,
                    email 
                FROM 
                    user 
                WHERE  
                    idCompany = $idCompany' ;
        mysql_select_db('PIMPSYS');
        $retval = mysql_query( $sql, $con );
        
        if(! $retval ) {
            die('Could not get data: ' . mysql_error());
        }

        echo "Fetched data successfully\n";
        mysql_close($con);

    return $retval;
}




?>