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
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
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

        .form input {
            height: 60px;
        }

        .btnlogin {
            height: 5rem;
        }
    </style>
</head>

<body style="background-color: black;">

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
                <a href="../paginas/time-view.php" class="btn"><i class="bi bi-file-person"></i> Equipe</a><br> <a
                    href="../paginas/sobre.php" class="btn"><i class="bi bi-info-square"></i> Sobre o
                    projeto</a><br>

              <?php
                if (isset($_SESSION["usu_codigo"])) {
                    echo '<a href="./pub-create.php">
                    <button class="botao-pub btn btn-light rounded-pill p-2 w-75" style="font-weight: bold;">Publicar</button>
                </a>';
                }
                ?>


            </div>
        </div>

        <div class="logo">
            <a href="../index.php">
                <img class="img" src="../img/1.png" alt="" width:="70px" height="70px">
            </a>
        </div>



        <h1 class="montserrat text-light" style="margin-left: 2rem;">ATLETA</h1>
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
                <li><a href='../paginas/usu-view.php?id=" . $_SESSION["usu_codigo"] . "' class='btn' style='color: gray;'><i class='bi bi-pencil-square'></i> Ver Perfil</a></li>
                <li><a href='logout.php' class='btn' style='color: red;'><i class='bi bi-door-open text-danger'></i> Sair</a><br></li>
            </ul>
        </div>";
            // Exibir conteúdo para usuários logados
        
        }

        ?>
    </nav>

    <div
        style="background-image: url('../img/basketball-black-3840x2160-17410.jpg'); width: 100%; height: 200%; background-size: cover; ">
        <div class="fora container">
            <div class="conteudo col-lg-12 text-center p-4 mt-5 position-relative">

                <?php
                require './Conn.php';
                require './Atleta.php';
                require './Usuario.php';

                $formData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                if (!isset($_SESSION['usu_codigo'])) {
                    echo "<div class='container'>
            <div style='border-radius: 20px; overflow-wrap: break-word;' class='position-item col-md-12 bg-dark justify-content-center text-light p-3 m-2'>";
                    echo '<h1 class="montserrat text-center">FAÇA LOGIN PARA EDITAR O ATLETA</h1>';

                    echo "</div>
            </div>";

                } else {
                    if (!empty($formData['salvar'])) {

                        $edit = new Atleta();
                        $edit->id = $id;
                        $edit->formData = $formData;

                        $foto = null;

                        if (isset($formData['remover-imagem']) && $formData['remover-imagem'] == 1) {
                            $atleta = $edit->viewIndividual();

                            if ($atleta && !empty($atleta['atl_foto'])) {
                                $nomeArquivoAntigo = $atleta['atl_foto'];
                                $caminhoArquivoAntigo = '../upload/atleta/' . $nomeArquivoAntigo;

                                if (file_exists($caminhoArquivoAntigo)) {
                                    unlink($caminhoArquivoAntigo);
                                    // Opcional: Atualizar o campo pub_conteudo no banco para NULL
                                    $edit->editFoto(null);
                                    $_SESSION['msg_atl_edit'] = "<h4 style='color: #00d10a; text-align: center'>Edição Realizada com Sucesso!</h4>";
                                    header("Location: ../paginas/time-view.php");
                                }
                            }

                        }

                        if (isset($_FILES['conteudo']) && $_FILES['conteudo']['error'] == UPLOAD_ERR_OK) {

                            $uploaddir = '../upload/atleta/';
                            $nome_arquivo = uniqid() . "_" . $_FILES['conteudo']['name'];
                            $caminho_completo = $uploaddir . $nome_arquivo;

                            if (move_uploaded_file($_FILES['conteudo']['tmp_name'], $caminho_completo)) {
                                $foto = $nome_arquivo;
                                // Atualizar o campo pub_conteudo no banco com o novo nome do arquivo
                                $edit->editFoto($foto);

                                $_SESSION['msg_atl_edit'] = "<h4 style='color: #00d10a; text-align: center'>Edição Realizada com Sucesso!</h4>";
                                header("Location: ../paginas/time-view.php"); //Direciona para outra página
                

                            } else {
                                echo "<h4 style='color: red; text-align: center'>Erro ao mover o novo arquivo para o servidor!</h4>";
                            }

                        } else if (isset($_FILES['conteudo']) && $_FILES['conteudo']['error'] != UPLOAD_ERR_NO_FILE) {
                            // Houve um erro no upload (diferente de nenhum arquivo enviado)
                            echo "<h4 style='color: red; text-align: center'>Erro no upload do arquivo: " . $_FILES['conteudo']['error'] . "</h4>";
                        }

                        $valor = $edit->edit();

                        if ($valor) {
                            $_SESSION['msg_atl_edit'] = "<h4 style='color: #00d10a; text-align: center'>Edição Realizada com Sucesso!</h4>";
                            header("Location: ../paginas/time-view.php"); //Direciona para outra página
                            exit();

                        }

                    }

                    $usuario = new Usuario();
            
                        if ($usuario->autorizacao($_SESSION['usu_codigo']) == false) {
                            echo '<h2>Acesso Negado</h2>';
                            exit();
                        }


                    // Crie uma instância da classe Usuario
                    if (!empty($id)) {

                        //instanciar e criar obj
                        $view = new Atleta();
                        //enviando id para o atributo id de User
                        $view->id = $id;
                        //instanciando o método visualizar/view
                        $valor = $view->viewIndividual();


                        if (is_array($valor)) {

                            extract($valor);
                        }
                        // Usuário tem permissão para publicar
                        echo '
                        <h1 class="montserrat">ADICIONAR ATLETA</h1>
                        <form class="form" method="post" enctype="multipart/form-data">
                            <span>Nome do Atleta:</span><br>
                            <input class="mb-5" type="text" name="nome" id="nome" style="color: black;" required
                            placeholder="Digite o nome do atleta" value="' . $atl_nome . '">

                            <span>Idade do Atleta:</span><br>
                            <input class="mb-5" type="number" name="idade" id="idade" style="color: black;" required
                            placeholder="Digite a idade do atleta" value="' . $atl_idade . '"> 

                            <span>Cidade:</span><br>
                            <select name="cidade" id="cidade" required value="' . $atl_cidade . '">
                                <option>Presidente Venceslau</option>
                            </select>
                            <span>Foto:</span><br>
                            <img class="d-block" style="max-width: 15rem; heigth: auto;" src="../upload/atleta/' . $atl_foto . '" alt="Foto do Atleta"><br>';

                        if (!empty($atl_foto)) {
                            echo '<label for="remover_imagem">Remover imagem atual</label>
                                <input type="checkbox" name="remover-imagem" id="remover-imagem" style="height: 30px;" value="1"> ';
                        }

                        echo '<span>Alterar foto:</span><br>
                            <input type="file" name="conteudo" id="conteudo" accept=".jpeg, .jpg, .png" style="color: black;"
                            placeholder="Selecione uma imagem">

                            <button class="btnlogin rounded-pill" type="submit" value="salvar" name="salvar"
                                style="color: white; margin-top: 10px;">EDITAR</button>
                        </form>
                        <a href="../paginas/time-view.php">
                        <button class="btn btn-danger rounded-pill w-100 mt-3 p-4 mb-2">VOLTAR</button>
                        </a>
            </div>
            
        </div>
    </div>
';
                    }
                }
                ?>

            </div>

        </div>
    </div>






    <!-- <button id="btnTopo" title="Voltar ao topo" class="btn btn-primary text-light rounded-pill"
        style="z-index: 99; bottom: 20px; right: 30px; position: fixed; display: none;">
        <i class="bi bi-chevron-up"></i>
    </button> -->



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>

    <script>
        let btnTopo = document.getElementById("btnTopo");

        // Exibe o botão quando o usuário rola para baixo 20px da parte superior da página
        window.onscroll = function () { scrollFunction() };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                btnTopo.style.display = "block";
            } else {
                btnTopo.style.display = "none";
            }
        }

        // Rola suavemente de volta ao topo quando o botão é clicado
        btnTopo.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</body>

</html>