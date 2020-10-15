<?php
session_start();
require 'config.php';

if(isset($_POST['agencia']) && !empty($_POST['agencia'])){
    $agencia = addslashes($_POST['agencia']);
    $conta = addslashes($_POST['conta']);
    $senha = addslashes($_POST['senha']);
    
    $sql = $pdo->prepare("SELECT * FROM contas WHERE agencia = :agencia AND conta = :conta AND senha = :senha");
    $sql->bindValue(":agencia", $agencia);
    $sql->bindValue(":conta", $conta);
    $sql->bindValue(":senha", md5($senha));
    $sql->execute();

    if($sql->rowCount() > 0){
        $sql = $sql->fetch();

        $_SESSION['banco'] = $sql['id'];
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Banco XYZ</title>
</head>
<body>
<h1>Favor Digitar seus dados abaixo para entrar</h1>
    <form method="POST">
        <label>Agencia </label><br/>
        <input type="text" name="agencia" /><br/><br/>
        
        <label>Conta</label><br/>
        <input type="text" name="conta" /><br/><br/>
    
        <label>Senha</label><br/>
        <input type="password" name="senha" /><br/><br/>    
        
        <input type="submit" value="Entrar" />
    </form>
</body>
</html>