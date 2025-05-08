<?php
session_start();
ob_start();
//receber o id do usuario vindo do home
//$id = filter_input()
//ou
$id = $_GET['id'];

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styleindex.css">
    <link rel="stylesheet" href="../css/stylefonts.css">
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
            border: none;
        }
    </style>
</head>

<body
    style="background-image: url('../img/basketball-black-3840x2160-17410.jpg'); width: 100%; height: 100%; background-size: cover; ">
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
                <a href="../paginas/sobre.php" class="btn"><i class="bi bi-info-square"></i> Sobre o projeto</a><br>

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
            <h2 class="montserrat d-none d-md-block" style="color: white; margin-left: 3rem;">VISUALIZAR PERFIL</h2>
        </div>

        <div></div>

        <?php
        if (!isset($_SESSION["usu_codigo"])) {
            echo "<div class='buttons'>
            <a href='../config/usu-login.php'>
                <button class='btn-entrar'>Entrar</button>
            </a>
            <a href='../config/usu-create.php'>
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
                <li><a href='../config/logout.php' class='btn' style='color: red;'><i class='bi bi-door-open text-danger'></i> Sair</a><br></li>
            </ul>
        </div>";

        }

        ?>
    </nav>

    <div class="fora container">
        <div class="conteudo col-lg-12 text-center p-4 mt-5 position-relative">

            <?php

            if (!isset($_SESSION['usu_codigo'])) {
                echo "<div class='container'>
        <div style='border-radius: 20px; overflow-wrap: break-word;' class='position-item col-md-12 bg-dark justify-content-center text-light p-3 m-2'>";
                echo '<h1 class="montserrat text-center">FAÇA LOGIN PARA VISUALIZAR O PERFIL</h1>';

                echo "</div>
        </div>";

            } else {
                if (!empty($id)) {
                    //incluir arquivos
                    require '../config/Conn.php';
                    require '../config/Usuario.php';

                    //instanciar e criar obj
                    $view = new Usuario();
                    //enviando id para o atributo id de User
                    $view->id = $id;
                    //instanciando o método visualizar/view
                    $valor = $view->view();

                    extract($valor);

                    if ($usu_ativo == 0) {
                        echo "O perfil não existe";
                        exit();

                    }


                    echo "<div class='container-fluid' style=''>";
                    echo ' <div class="row text-center justify-content-evenly p-5">
                                <div class="col-4 p-2">
                                <h3><strong>Foto de Perfil</strong></h3><br>';

                    if ($usu_foto == null) {
                        echo '<img class="imagem d-block" style="margin: 0 auto; border-radius: 20px;" src="../upload/perfil/padrao.jpg" alt="Foto de perfil">';
                    } else {
                        echo '<img class="imagem-sobre d-block" style="margin: 0 auto; border-radius: 20px;" src="../upload/perfil/' . $usu_foto . '" alt="Foto de perfil">';
                    }


                    echo '</div>';
                    echo '
                                <div class="col-6 p-2">';

                    echo "<h3><i class='bi bi-person'></i> " . $usu_nome . "</h3>";
                    echo "<h3 class='poppins-bold' style='font-size: calc(0.8em + 1vw); margin-left: 2vw;'>" . $usu_email . "</h3><br>";
                    if ($usu_telefone != 0) {
                        echo "<h3 style=' margin-left: 1rem;'>" . $usu_telefone . "</h3><br>";
                    }
                    if ($usu_estado !== null) {
                        echo "<h3 style=' margin-left: 1rem;'>" . $usu_estado . "</h3><br>";
                    }

                    if ($usu_cidade !== null) {
                        echo "<h3 style=' margin-left: 1rem;'>" . $usu_cidade . "</h3><br>";
                    }

                    $dataF = new DateTime($created);
                    $dataFormatada = $dataF->format('d/m/Y');

                    echo "<p style='font-size: 20px;'><i class='bi bi-clock'></i> Criado em " . $dataFormatada . "</p><br>";

                    if ($_SESSION["usu_codigo"] == $usu_codigo) {
                        echo "
                                    <div class='botoes-edit'>
                                    <a href='../config/usu-edit.php?id=" . $usu_codigo . "' style='text-decoration: none; color: white;'>
                                    <button class='btn rounded-pill m-2 w-100' title='Editar usuário'><i class='bi bi-pencil-square'></i> Editar usuário</button>
                                    </a>
                                    ";
                    }

                } else {
                    echo "<h1 style='color: #f00'>
                            Erro: Registro não encontrado
                            </h1>";
                }

                echo '      </div>
                            </div>';
                echo "</div>";
            }
            if (isset($_SESSION['adm_codigo'])) {
                echo ' <div class="botoes-edit">
                <a href="../config/adm-list-usu.php">
                    <button class="btn bg-danger rounded-pill m-2 text-center" style="width: 32vw;">Voltar</button>
                </a>
            </div>';
            } else {
                echo ' <div class="botoes-edit">
                <a href="../index.php">
                    <button class="btn bg-danger rounded-pill m-2 text-center" style="width: 32vw;">Voltar</button>
                </a>
            </div>';
            }

            ?>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>

    <script src="../js/funcao.js"></script>

</body>

</html>