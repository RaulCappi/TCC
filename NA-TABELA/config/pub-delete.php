<?php
session_start();
ob_start();
$id = $_GET['id'];

if (!empty($id)) {
    require './Conn.php';
    require './Publicacao.php';

    // Buscar os detalhes da publicação para verificar se há uma imagem associada
    $publicacao = new Publicacao();
    $publicacao->id = $id;
    $detalhesPublicacao = $publicacao->viewIndividual();
    
    $apagouArquivo = false;
    if ($detalhesPublicacao && !empty($detalhesPublicacao['pub_conteudo'])) {
        $nomeArquivo = $detalhesPublicacao['pub_conteudo'];
        $caminhoArquivo = '../upload/posts/' . $nomeArquivo;

        if (file_exists($caminhoArquivo)) {
            if (unlink($caminhoArquivo)) {
                $apagouArquivo = true;
            }
        } else {
            $apagouArquivo = true; // Consideramos como se a intenção de apagar foi cumprida (não havia o que apagar)
        }
    }

    $del = new Publicacao();
    $del->id = $id;
    $valor = $del->delete();


        if ($valor) {
            if (isset($_SESSION['adm_codigo'])) {
                $_SESSION['msg_pub_delete'] =
                "<h5 style='color:green; text-align: center'>Publicação excluida com sucesso!</h5>";
                header("Location: ../adm/adm-list-posts.php");
            }

            $_SESSION['msg_pub_delete'] =
                "<h5 style='color:green; text-align: center'>Publicação excluida com sucesso!</h5>";
            header("Location: ../index.php");
        } else {
            echo "<h5 style='color:red; text-align: center'>Erro: Registro não encontrado</h5>";
            header("Location: ../index.php");
        }
    }


