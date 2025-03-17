<?php
session_start();
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
        }

        .fora::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            /* Cor de fundo com opacidade */
            backdrop-filter: blur(10px);
            margin-top: 2rem;

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
    <?php
    require './Conn.php';
    require './Publicacao.php';
    require './Usuario.php';

    $formData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $usuarioCodigo = $_SESSION["usu_codigo"];




    if (!empty($formData['publicar'])) {
        $create = new Publicacao();
        $create->formData = $formData;

        $uploaddir = '../upload/posts/';
        $nome_arquivo = uniqid() . "_" . $_FILES['conteudo']['name'];
        $caminho_completo = $uploaddir . $nome_arquivo;
        $arquivo = $nome_arquivo;


        if ($_FILES['conteudo']['error'] == UPLOAD_ERR_OK) {
            if (move_uploaded_file($_FILES['conteudo']['tmp_name'], $caminho_completo)) {
                $valor = $create->create($usuarioCodigo, $arquivo);
                
                if ($valor) {
                    $_SESSION['msg_publicacao'] =
                        "<h5 style='color: green; text-align: center'>Publicação criada com sucesso!</h5>";
                    header("Location: ../index.php"); //vai pra pagina que você quiser
                } else {
                    echo "<h4 style='color: red; text-align: center'>Falha na Publicação!</h4>";
                }

            }
        }
    }



    ?>
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
                <a href="" class="btn"><i class="bi bi-calendar4-week"></i> Jogos</a><br>
                <a href="" class="btn"><i class="bi bi-file-person"></i> Equipe</a><br>
                <a href="../front-end/sobre.php" class="btn"><i class="bi bi-info-square"></i> Sobre o
                    projeto</a><br>

                <a href="./back-end/pub-create.php"><button class="btn btn-danger rounded-pill p-2 w-75"
                        style="font-weight: bold;">Publicar</button></a>


            </div>
        </div>

        <div class="logo">
            <a href="../index.php">
                <img class="img" src="../img/1.png" alt="" width:="70px" height="70px">
            </a>
        </div>

        <input type="text" class="d-none d-md-block" placeholder="Pesquise uma publicação"
            style="width: 40%; height: 35px; text-align: center; border-radius: 20px; border: none; margin-right: 6rem;">

        <?php
        if (!isset($_SESSION["usu_codigo"])) {
            echo "<div class='buttons'>
            <a href='back-end/usu-login.php'>
                <button class='btn-entrar'>Entrar</button>
            </a>
            <a href='back-end/usu-create.php'>
                <button class='btn-entrar'>Cadastre-se</button>
            </a>

        </div>";
        } else {
            echo "<div class='nav-item dropdown'>
            <a class='nav-link text-light' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                <h4 style='color: white;'>Olá, " . $_SESSION["usu_nome"] . "! <i class='bi bi-caret-down-fill'></i></h4>
            </a>
            <ul class='dropdown-menu text-center'>
                <li><a href='' class='btn' style='color: gray;'><i class='bi bi-gear'></i> Configuração</a></li>
                <li><a href='logout.php' class='btn' style='color: red;'><i class='bi bi-door-open text-danger'></i> Sair</a><br></li>
            </ul>
        </div>";
            // Exibir conteúdo para usuários logados
        
        }

        ?>
    </nav>

    <div
        style="background-image: url('../img/basketball-black-3840x2160-17410.jpg'); width: 100%; height: 120%; background-size: cover; ">
        <div class="fora container">
            <div class="conteudo col-lg-12 text-center p-5 position-relative">

                <?php
                // Crie uma instância da classe Usuario
                $usuario = new Usuario();

                if (isset($_SESSION['usu_codigo'])) {
                    $usu_codigo = $_SESSION['usu_codigo'];

                    if ($usuario->autorizacao($usu_codigo)) {
                        // Usuário tem permissão para publicar
                        echo '
                        <h1>NOVA PUBLICAÇÃO</h1>
                        <form class="form" method="post" enctype="multipart/form-data">
                            <span>Título da Publicação:</span><br>
                            <input class="mb-5" type="text" name="titulo" id="titulo" style="color: black;" required
                            placeholder="Digite o titulo da publicação">

                            <span>Descrição:</span><br>
                            <textarea name="descricao" id="descricao" style="color: black;" rows="5" cols="50"
                            placeholder="Digite a descrição da publicação"></textarea> <br>

                            <span>Conteúdo:</span><br>
                            <input type="file" name="conteudo" id="conteudo" style="color: black;"
                            placeholder="Selecione uma imagem">

                            <button class="btnlogin rounded-pill" type="submit" value="Publicar" name="publicar"
                                style="color: white; margin-top: 10px;">PUBLICAR</button>
                        </form>
            </div>
        </div>
    </div>
';
                    } else {
                        // Usuário não tem permissão para publicar
                        echo '<h1>ACESSO NÃO AUTORIZADO</h1><br>
                        <p style="font-size: 25px;">Seu perfil não possui permições necessárias para realizar publicações no site, torne-se um parceiro entrando em contato com a administração e poderá ter acesso à essa utilidade.</p>
                        <p style="font-size: 25px;">Contato: (xx) xxxxx-xxxx</p>
                        <p style="font-size: 25px;">E-mail: aksjdndsjkn@gmail.com</p>';

                    }
                } else {
                    echo '<h1>Página Bloqueada</h1>';
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