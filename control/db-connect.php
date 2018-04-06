<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
 define('MYSQL_HOST', 'localhost');
 define('MYSQL_USER', 'root'); 
 define('MYSQL_PASSWORD', '1706');
 define('MYSQL_DB_NAME', 'social');

//define('MYSQL_HOST', 'localhost');
//define('MYSQL_USER', 'root'); 
//define('MYSQL_PASSWORD', '170698');
//define('MYSQL_DB_NAME', 'minhasaulasonline');


    try
    {
        $pdo = new PDO( 'mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB_NAME, MYSQL_USER, MYSQL_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));  
    }
    catch(PDOException $e)
    {
        echo 'Erro ao conectar ao host: ' . $e->getMessage();
    }


// mysqli_query('SET character_set_connection=utf8');
// mysqli_query('SET character_set_client=utf8');
// mysqli_query('SET character_set_results=utf8');
?>
