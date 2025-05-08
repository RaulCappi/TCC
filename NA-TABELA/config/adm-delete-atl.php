<?php
session_start();
ob_start();
$id = $_GET['id'];

if (!empty($id)) {
    require './Conn.php';
    require './Atleta.php';

    // Buscar os detalhes da publicação para verificar se há uma imagem associada
    $atleta = new Atleta();
    $atleta->id = $id;
    $atletaUnico = $atleta->viewIndividual();

    $apagouArquivo = false;

    if ($atletaUnico && !empty($atletaUnico['atl_foto'])) {
        $nomeArquivo = $atletaUnico['atl_foto'];
        $caminhoArquivo = '../upload/atleta/' . $nomeArquivo;

        if (file_exists($caminhoArquivo)) {
            if (unlink($caminhoArquivo)) {
                $apagouArquivo = true;
            }
        } else {
            $apagouArquivo = true; // Consideramos como se a intenção de apagar foi cumprida (não havia o que apagar)
        }
    }

    $del = new Atleta();
    $del->id = $id;
    $valor = $del->delete();


    if ($valor) {

        $_SESSION['msg_atl_delete'] =
            "<h5 style='color:green; text-align: center'> Atleta excluido com sucesso!</h5>";
        header("Location: ./adm/adm-list-atl.php");
    } else {
        echo "<h5 style='color:red; text-align: center'>Erro: Registro não encontrado</h5>";
        header("Location: ./adm/adm-list-atl.php");
    }
}
