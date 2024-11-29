<?php
 # Informações sobre o banco de dados:
    $db_host = "localhost";
    $db_nome = "ajaxdb";
    $db_usuario = "root";
    $db_senha = "";
    $db_driver = "mysql";


try{
    // Faz conexão com banco de daddos
    $pdo =  new PDO("$db_driver:host=$db_host; dbname=$db_nome", $db_usuario, $db_senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
       echo  'Falha ao conectar no banco de dados: '.$e->getMessage();



}
