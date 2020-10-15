<?php
session_start();
//destroi a sessão do usuario
unset($_SESSION['banco']);
//volta para a tela do index
header("Location: index.php");
exit;
?>