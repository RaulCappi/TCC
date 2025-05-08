<?php
session_start();
ob_start();
$id = $_GET['id'];

if (!empty($id)) {
    require '../Conn.php';
    require '../Usuario.php';

    $usu = new Usuario();
    $usu->id = $id;

    $perm = 1;

    $valor = $usu->permitirUsu($perm);

    if ($valor) {
            $_SESSION['msg_usu_perm'] =
                "<h4 style='color: #00d10a; text-align: center'>Registro permitido com sucesso!</h4>";
            header("Location: ./adm-list-usu.php");
            exit();
        } else {
            echo "<h4 style='color: red; text-align: center'>Não foi possível permitir o perfil!</h4>";
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