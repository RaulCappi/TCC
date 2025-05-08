<?php
session_start();
ob_start();

$id = isset($_GET['id']) ? $_GET['id'] : null;

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styleindex.css">
    <link rel="stylesheet" href="../css/stylefonts.css">
    <link rel="stylesheet" href="../css/stylelogin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=67e2217bbc16930012085add&product=inline-share-buttons&source=platform"
        async="async"></script>

    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Na Tabela</title>

    <style>
        .btn:hover {
            color: grey;
        }

        .btn {
            font-size: large;
        }

        .fora {
            position: relative;
            overflow: hidden;
            border-radius: 30px;
        }

        .fora::before {
            content: "";
            position: absolute;
            width: 98%;
            height: 95.5%;
            background-color: rgba(255, 255, 255, 0.9);
            /* Cor de fundo com opacidade */
            backdrop-filter: blur(10px);
            margin-top: 2rem;
            border-radius: 30px;
            /* Coloca o pseudo-elemento atrás do conteúdo */
        }


        .botoes-edit button {
            border: 1px solid white;
            color: white;
            background-color: black;
            padding: 10px;
        }

        .botoes-edit button:hover {
            background-color: white;
            color: black;
            border: 2px solid black;
        }

        .form input {
            width: 32vw;
        }

        .form select {
            width: 32vw;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <a class="btn" data-bs-toggle="offcanvas" href="#menu-lateral">
            <i class="bi bi-list text-light"></i></a>

        <div class="offcanvas offcanvas-start bg-dark" tabindex="-1" id="menu-lateral">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasLabel" style="color: white; margin-top: 10px;">Menu lateral
                </h5>
                <button type="button" class="btn text-reset mt-2" data-bs-dismiss="offcanvas" aria-label="Close"><i
                        class="bi bi-x-lg text-light"></i></button>

            </div>
            <hr style="color: white;">
            <div class="offcanvas-body d-flex flex-column">
                <a href="../index.php" class="btn"><i class="bi bi-house"></i>
                    Página inicial</a><br>

                <a href="../paginas/treino-view.php" class="btn"><i class="bi bi-calendar4-week"></i> Treinos</a><br>
                <a href="../paginas/time-view.php" class="btn"><i class="bi bi-file-person"></i> Equipe</a><br>
                <a href="./paginas/sobre.php" class="btn"><i class="bi bi-info-square"></i> Sobre o projeto</a><br>

                <a href="../config/pub-create.php">
                    <button class="botao-pub btn btn-light rounded-pill p-2 w-75"
                        style="font-weight: bold;">Publicar</button>
                </a>
            </div>
        </div>

        <div class="logo">
            <a href="../index.php">
                <img class="img" src="../img/1.png" alt="" width:="70px" height="70px">
            </a>
        </div>

        <div>
            <h2 class="montserrat d-none d-md-block" style="color: white; margin-left: 3rem;">EDITAR PERFIL</h2>
        </div>

        <div></div>

        <?php
        if (!isset($_SESSION["usu_codigo"])) {
            echo "<div class='buttons'>
            <a href='./usu-login.php'>
                <button class='btn-entrar'>Entrar</button>
            </a>
            <a href='./usu-create.php'>
                <button class='btn-entrar'>Cadastre-se</button>
            </a>

        </div>";
        } else {
            echo "<div class='nav-item dropdown'>
            <a class='nav-link text-light' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                <h4 style='color: white;'>Olá, " . $_SESSION["usu_nome"] . "! <i class='bi bi-caret-down-fill'></i></h4>
            </a>
            <ul class='dropdown-menu text-center'>
                <li><a href='' class='btn' style='color: gray;'><i class='bi bi-pencil-square'></i> Ver Perfil</a></li>
                <li><a href='./logout.php' class='btn' style='color: red;'><i class='bi bi-door-open text-danger'></i> Sair</a><br></li>
            </ul>
        </div>";

        }

        ?>
    </nav>
    <div
        style="background-image: url('../img/basketball-black-3840x2160-17410.jpg'); width: 100%; height: 200%; background-size: cover; ">
        <div class="fora container">
            <div class="conteudo col-lg-12 text-center p-4 mt-5 position-relative">

                <?php
                require './Conn.php';
                require './Usuario.php';

                $formData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                if (!isset($_SESSION['usu_codigo'])) {
                    echo "<div class='container'>
        <div style='border-radius: 20px; overflow-wrap: break-word;' class='position-item col-md-12 bg-dark justify-content-center text-light p-3 m-2'>";
                    echo '<h1 class="montserrat text-center">FAÇA LOGIN PARA EDITAR O PERFIL</h1>';

                    echo "</div>
        </div>";

                } else {
                    if (!empty($formData['salvar'])) {

                        $edit = new Usuario();
                        $edit->id = $id;
                        $edit->formData = $formData;

                        $foto = null;

                        if (isset($formData['remover-imagem']) && $formData['remover-imagem'] == 1) {
                            $usuario = $edit->view();

                            if ($usuario && !empty($usuario['usu_foto'])) {
                                $nomeArquivoAntigo = $usuario['usu_foto'];
                                $caminhoArquivoAntigo = '../upload/perfil/' . $nomeArquivoAntigo;

                                if (file_exists($caminhoArquivoAntigo)) {
                                    unlink($caminhoArquivoAntigo);
                                    // Opcional: Atualizar o campo pub_conteudo no banco para NULL
                                    $edit->editFoto(null);

                                    $_SESSION['msg_usu_edit'] = "<h4 style='color: #00d10a; text-align: center'>Edição Realizada com Sucesso!</h4>";
                                    header("Location: ../index.php");
                                }
                            }

                        }

                        if (isset($_FILES['conteudo']) && $_FILES['conteudo']['error'] == UPLOAD_ERR_OK) {

                            $uploaddir = '../upload/perfil/';
                            $nome_arquivo = uniqid() . "_" . $_FILES['conteudo']['name'];
                            $caminho_completo = $uploaddir . $nome_arquivo;

                            if (move_uploaded_file($_FILES['conteudo']['tmp_name'], $caminho_completo)) {
                                $foto = $nome_arquivo;
                                // Atualizar o campo pub_conteudo no banco com o novo nome do arquivo
                                $edit->editFoto($foto);

                                $_SESSION['msg_usu_edit'] = "<h4 style='color: #00d10a; text-align: center'>Edição Realizada com Sucesso!</h4>";
                                header("Location: ../index.php");

                            } else {
                                echo "<h4 style='color: red; text-align: center'>Erro ao mover o novo arquivo para o servidor!</h4>";
                            }

                        } else if (isset($_FILES['conteudo']) && $_FILES['conteudo']['error'] != UPLOAD_ERR_NO_FILE) {
                            // Houve um erro no upload (diferente de nenhum arquivo enviado)
                            echo "<h4 style='color: red; text-align: center'>Erro no upload do arquivo: " . $_FILES['conteudo']['error'] . "</h4>";
                        }

                        $valor = $edit->edit();

                        if ($valor) {
                            $_SESSION['msg_usu_edit'] = "<h4 style='color: #00d10a; text-align: center'>Edição Realizada com Sucesso!</h4>";
                            header("Location: ../index.php"); //Direciona para outra página
                            exit();

                        }

                    }
                    if (!empty($formData['excluir'])) {
                        header("Location: ./logout.php");

                    }

                    if (!empty($id)) {

                        //instanciar e criar obj
                        $view = new Usuario();
                        //enviando id para o atributo id de User
                        $view->id = $id;
                        //instanciando o método visualizar/view
                        $valor = $view->view();


                        if (is_array($valor)) {

                            extract($valor);
                        } else {
                            // Usuário não encontrado (possivelmente foi excluído)
                            header("Location: ./logout.php");
                            exit();
                        }

                        if ($_SESSION["usu_codigo"] != $usu_codigo) {
                            echo '<h2>Acesso negado</h2>';
                            exit();
                        } 

                        echo "<div class='container-fluid' style=''>";
                        echo ' <div class="row text-center justify-content-between p-2">
                                <div class="col-4 p-3">

                                <h4 class="mb-5"><strong>FOTO DE PERFIL</strong></h4>';

                        if ($usu_foto == null) {
                            echo '<img class="imagem d-block mb-5" style="margin: 0 auto; border-radius: 20px;" src="../upload/perfil/padrao.jpg" alt="Foto de perfil">';
                        } else {
                            echo '<img class="imagem-sobre d-block mb-5" style="margin: 0 auto; border-radius: 20px;" src="../upload/perfil/' . $usu_foto . '" alt="Foto de perfil">';
                        }


                        echo '
                                </div>';


                        echo '
                                <div class="col-6 p-1">

                                <form class="form" method="post" enctype="multipart/form-data">
                            
                                <span>Nome de usuário:</span><br>
                                <input type="text" name="nome" id="nome" placeholder="Seu nome" value="' . $usu_nome . '"><br>
            
                                <span>Email:</span><br>
                                <input type="email" name="email" id="email" placeholder="Seu email" value="' . $usu_email . '"><br>';

                                if ($usu_telefone != 0) {
                                echo '<span>Telefone (celular):</span><br>
                                <input type="text" name="telefone" id="telefone" placeholder="Seu telefone" value="' . $usu_telefone . '"><br>';
                                }
            
                                echo '<span>Seu Estado:</span><br>
                                <select name="estado" id="estado" value="' . $usu_estado . '">
                                    <option value="" disabled selected>Estado</option>
                                </select><br>
            
                                <span>Sua Cidade:</span><br>
                                <select name="cidade" id="cidade" value="' . $usu_cidade . '">
                                    <option value="" disabled selected>Cidade</option>
                                </select><br>';

                        if (!empty($usu_foto)) {
                            echo '<label for="remover_imagem" style="font-size: 1.2rem;">Remover imagem atual</label><br>
                            <input type="checkbox" name="remover-imagem" id="remover-imagem" style="height: 20px; width: 20px; margin-left: 1rem;"   value="1"><br> ';
                        }

                        echo '<span>Alterar foto de perfil:</span><br>
                                <input type="file" name="conteudo" id="conteudo" style="height: 60px" accept=".jpeg, .jpg, .png" style="color: black;"
                                placeholder="Selecione uma imagem">
            
                                <div class="botoes-edit text-center">
                                <button class="btn rounded-pill m-2 text-center" style="width: 25vw;" type="submit" value="Salvar" name="salvar">EDITAR</button>
                                
                                <a href="javascript:void(0);" onclick="confirmaExclusaoUser(' . $usu_codigo . ')">
                                <button class="btn rounded-pill m-2" title="Excluir usuário" value="excluir" name="excluir" style="width: 25vw;"><i class="bi bi-trash"></i> Excluir</button>
                                </a>
                                
                                </div>
                                
                                </form>
                    
                                ';


                        if (!empty($formData['salvar'])) {
                            $_SESSION['usu_nome'] = $usu_nome;
                        }
                    } else {
                        echo "<h1 style='color: #f00'>
                        Erro: Registro não encontrado
                        </h1>";
                    }
                }
                ?>





            </div>
            <div class="botoes-edit">
                <a href="../index.php">
                    <button class="btn bg-danger rounded-pill m-2 text-center" style="width: 32vw;">Voltar</button>
                </a>
            </div>
        </div>
    </div>

    <!-- <footer>
        <div style="background-color:rgb(30, 30, 30);" class="position-relative text-center justify-content-center p-5 text-light ">
            <h5>Footer Footer Footer</h5>
            <p>FooterFooterFooterFooterFooterFooterFooterFooter</p>
        </div>
    </footer> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/gh/robertocr/cidades-estados-js/cidades-estados-1.4-utf8.js"></script>
    <script src="../js/funcao.js"></script>
    <script language="JavaScript" type="text/javascript" charset="utf-8">
        window.onDomReady(function () { // Garante que o DOM esteja carregado
            new dgCidadesEstados({
                cidade: document.getElementById('cidade'),
                estado: document.getElementById('estado')
            });
        });
    </script>

</body>

</html>