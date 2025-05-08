<?php
session_start();
ob_start();
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
    <?php
    require './Conn.php';
    require './Atleta.php';
    require './Usuario.php';

    $formData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    if (isset($_SESSION['usu_codigo'])) {
        $usuarioCodigo = $_SESSION['usu_codigo'];
    }


    if (!empty($formData['adicionar'])) {
        $create = new Atleta();
        $create->formData = $formData;

        $uploaddir = '../upload/atleta/';
        $arquivo = null; // Inicializa a variável $arquivo como null
    

        if (isset($_FILES['conteudo']) && $_FILES['conteudo']['error'] == UPLOAD_ERR_OK) {
            $nome_arquivo = uniqid() . "_" . $_FILES['conteudo']['name'];
            $caminho_completo = $uploaddir . $nome_arquivo;

            if (move_uploaded_file($_FILES['conteudo']['tmp_name'], $caminho_completo)) {
                $arquivo = $nome_arquivo;
            } else {
                echo "<h4 style='color: red; text-align: center'>Erro ao mover o arquivo para o servidor!</h4>";
            }

        } else if (isset($_FILES['conteudo']) && $_FILES['conteudo']['error'] != UPLOAD_ERR_NO_FILE) {
            // Houve um erro no upload (diferente de nenhum arquivo enviado)
            echo "<h4 style='color: red; text-align: center'>Erro no upload do arquivo: " . $_FILES['conteudo']['error'] . "</h4>";
        }

        // Cria a publicação, passando o $arquivo (que pode ser null se nenhum arquivo foi enviado)
        $valor = $create->create($arquivo);

        if ($valor) {
            $_SESSION['msg_atleta_add'] =
                "<h5 style='color: green; text-align: center'>Atleta adicionado com sucesso!</h5>";
            header("Location: ../paginas/time-view.php"); //vai pra pagina que você quiser
            exit();
        } else {
            echo "<h4 style='color: red; text-align: center'>Falha ao adicionar atleta!</h4>";
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
                <a href="../paginas/treino-view.php" class="btn"><i class="bi bi-calendar4-week"></i> Treinos</a><br>
                <a href="../paginas/time-view.php" class="btn"><i class="bi bi-file-person"></i> Equipe</a><br>                <a href="../paginas/sobre.php" class="btn"><i class="bi bi-info-square"></i> Sobre o
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
            <a href='config/usu-login.php'>
                <button class='btn-entrar'>Entrar</button>
            </a>
            <a href='config/usu-create.php'>
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
        style="background-image: url('../img/basketball-black-3840x2160-17410.jpg'); width: 100%; height: 120%; background-size: cover; ">
        <div class="fora container">
            <div class="conteudo col-lg-12 text-center p-4 mt-5 position-relative">

                <?php
                // Crie uma instância da classe Usuario
                $usuario = new Usuario();

                if (isset($_SESSION['usu_codigo'])) {
                    $usu_codigo = $_SESSION['usu_codigo'];

                    if ($usuario->autorizacao($usu_codigo)) {
                        // Usuário tem permissão para publicar
                        echo '
                        <h1 class="montserrat">ADICIONAR ATLETA</h1>
                        <form class="form" method="post" enctype="multipart/form-data">
                            <span>Nome do Atleta:</span><br>
                            <input class="mb-5" type="text" name="nome" id="nome" style="color: black;" required
                            placeholder="Digite o nome do atleta">

                            <span>Idade do Atleta:</span><br>
                            <input class="mb-5" type="number" name="idade" id="idade" style="color: black;" required
                            placeholder="Digite a idade do atleta"> 

                            <span>Cidade:</span><br>
                            <select name="cidade" id="cidade" required>
                                <option>Presidente Venceslau</option>
                            </select>

                            <span>Foto:</span><br>
                            <input type="file" name="conteudo" id="conteudo" accept=".jpeg, .jpg, .png" style="color: black;"
                            placeholder="Selecione uma imagem">

                            <button class="btnlogin rounded-pill" type="submit" value="Adicionar" name="adicionar"
                                style="color: white; margin-top: 10px;">ADICIONAR</button>
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