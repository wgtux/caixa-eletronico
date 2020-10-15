<?php
try{
$pdo = new PDO("mysql:dbname=banco;host=localhost", "root", "");
}
catch(PDOException $e){
    echo 'Erro'.$e->getMessage();
    exit;
}


?>