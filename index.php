<?php
session_start();
require 'config.php';

if(isset($_SESSION['banco']) && !empty($_SESSION['banco'])){
    $id = $_SESSION['banco'];

    $sql = $pdo->prepare("SELECT * FROM contas WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();

    //se existir usuario com essa id
    if($sql->rowCount() > 0){
        $info = $sql->fetch();
    }
    //se ele não encontrou o usuario com esse id vai para login
    else{
        header("Location: login.php");
        exit;
    }
    
}
else{
    header("Location: login.php");
    exit;
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
<h1>Bem Vindo ao Banco XYZ</h1>
<h2>Você esta em uma área segura</h2>
<br/><br/><br/>
<p>Titular: <?php echo $info['titular']; ?></p>
<p>Agencia: <?php echo $info['agencia']; ?></p>
<p>Conta: <?php echo $info['conta']; ?></p>
<p>Saldo: <?php echo $info['saldo']; ?></p>
<p><a href="sair.php">Sair</a>

<hr>

<a href="transacao.php">Adicionar Movimentação </a><br/><br/>

<h3>Movimentações/Operações</h3>

<table width="500">
    <tr>
        <th>Data</th>
        <th>Valor</th>
    </tr>
    <?php
    //id para pegar os dados do historico no cliente
    $sql = $pdo->prepare("SELECT * FROM historico WHERE id_conta = :id_conta");
    $sql->bindValue(":id_conta", $id);
    $sql->execute();

    if($sql->rowCount() > 0){
        foreach($sql->fetchAll() as $item){
            ?>
            <tr>
                <td><?php echo date('d/m/Y H:i', strtotime($item['data_operacao'])); ?> </td>
                <td>
                    <?php if($item['tipo'] == '0'): ?>
                    <font color="green">R$ <?php echo $item['valor'] ?> </font>
                    <?php else: ?>
                    <font color="red">-R$ <?php echo $item['valor'] ?> </font>
                    <?php endif; ?>
                </td>
            </tr>
            <?php
        }
    }
?>
</table>
</body>
</html>