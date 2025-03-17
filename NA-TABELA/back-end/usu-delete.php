<?php
session_start();
ob_start();
$id = $_GET['id'];

if (!empty($id)) {
    require './Conn.php';
    require './Usuario.php';

    $del= new Usuario();
    $del->id = $id;
    $valor = $del->delete();

    if ($valor) {
        if ($valor) {
            $_SESSION['msg'] =
                "<h4 style='color: #00d10a; text-align: center'>Registro excluido com sucesso!</h4>";
            header("Location: index.php");
        } else {
            echo "<h4 style='color: red; text-align: center'>Registro não excluído!</h4>";
            header("Location: index.php");
        }
    }

} else {
    $_SESSION['msg'] = "<p style='color: #f00'>
        Erro: Registro não encontrado
        </p>";
    header('Location: index.php');
}