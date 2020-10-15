<?php
session_start();
require 'config.php';

if(isset($_POST['tipo'])){
    $tipo = $_POST['tipo'];
    $valor = str_replace(",",".", $_POST['valor']); //substitui , por . (padrão portugues para americano)
    $valor = floatval($valor); //garante que o tipo de dado vai ser float

    $sql = $pdo->prepare("INSERT INTO historico (id_conta, tipo, valor, data_operacao) VALUES (:id_conta, :tipo, :valor, NOW())");
    //$sql = $pdo->prepare("INSERT INTO historico SET id_conta = :id_conta, tipo = :tipo, valor = :valor, NOW()");
    $sql->bindValue(":id_conta", $_SESSION['banco']);
    $sql->bindValue(":tipo", $tipo);
    $sql->bindValue(":valor", $valor);
    $sql->execute();

    //Alterar Saldo da conta conforme movimenta
    if($tipo == '0'){
        //deposito
        $sql = $pdo->prepare("UPDATE contas SET saldo = saldo + :valor WHERE id = :id");
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":id", $_SESSION['banco']);
        $sql->execute();
    }
    else{
        //saque
        $sql = $pdo->prepare("UPDATE contas SET saldo = saldo - :valor WHERE id = :id");
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":id", $_SESSION['banco']);
        $sql->execute();
    }

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=auto, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>transações</title>
</head>
<body>

<form method="POST">
    Tipo de Transação: <br/>
    <select name="tipo">
        <option value="0">Depósito</option>
        <option value="1">Retirada</option>
    </select><br/><br/>

    Valor: </br>
    <input type="text" name="valor" pattern="[0-9.,]{1,}" /><br/><br/>
    <input type="submit" value="Adicionar" />
</form>
    
</body>
</html>