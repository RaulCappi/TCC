<?php
session_start();
ob_start();
$id = $_GET['id'];

if (!empty($id)) {
    require '../Conn.php';
    require '../Usuario.php';

    $atv = new Usuario();
    $atv->id = $id;

    $ativo = 1;

    $valor = $atv->ativarUsu($ativo);

    if ($valor) {
            $_SESSION['msg_usu_ativo'] =
                "<h4 style='color: #00d10a; text-align: center'>Registro ativado com sucesso!</h4>";
            header("Location: ./adm-list-usu.php");
            exit();
        } else {
            echo "<h4 style='color: red; text-align: center'>Não foi possível ativar o perfil!</h4>";
            header("Location: ./adm-list-usu.php");
            exit();
        }   

} else {
    $_SESSION['msg'] = "<p style='color: #f00'>
        Erro: Registro não encontrado
        </p>";
    header('Location: ./adm-list-usu.php');
    exit();
}
?>