<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleindex.css">
    <link rel="stylesheet" href="css/stylefonts.css">
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

                <a href="index.php" class="btn" style="border: solid 1px white"><i class="bi bi-house"></i>
                    Página inicial</a><br>
                <a href="" class="btn"><i class="bi bi-calendar4-week"></i> Jogos</a><br>
                <a href="" class="btn"><i class="bi bi-file-person"></i> Equipe</a><br>
                <a href="./front-end/sobre.php" class="btn"><i class="bi bi-info-square"></i> Sobre o projeto</a><br>
                <?php
                if (isset($_SESSION["usu_codigo"])) {
                    echo '<a href="./back-end/pub-create.php">
                    <button class="btn btn-danger rounded-pill p-2 w-75" style="font-weight: bold;">Publicar</button>
                </a>';
            }
            ?>

            </div>
        </div>

        <div class="">
            <img class="img" src="img/1.png" alt="" width:="70px" height="70px">
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
                <li><a href='./back-end/logout.php' class='btn' style='color: red;'><i class='bi bi-door-open text-danger'></i> Sair</a><br></li>
            </ul>
        </div>";
            // Exibir conteúdo para usuários logados
        
        }

        ?>
    </nav>
    <?php
    if (isset($_SESSION['msg_login'])) {
        echo "<div>" . $_SESSION['msg_login'] . "</div>";
        unset($_SESSION['msg_login']); // Remove a variável de sessão para não exibir a mensagem novamente
    }

    if (isset($_SESSION['msg_cadastro'])) {
        echo "<div>" . $_SESSION['msg_cadastro'] . "</div>";
        unset($_SESSION['msg_cadastro']);
    }

    if (isset($_SESSION['msg_logout'])) {
        echo "<div>" . $_SESSION['msg_logout'] . "</div>";
        unset($_SESSION['msg_logout']);
    }

    if (isset($_SESSION['msg_publicacao'])) {
        echo "<div>" . $_SESSION['msg_publicacao'] . "</div>";
        unset($_SESSION['msg_publicacao']);
    }

    if (!isset($_SESSION["usu_codigo"])) {
        echo "<a href='./back-end/usu-login.php' style='text-decoration: none;'><h5 style='text-align: center; color: grey;'>
        Faça Login/Cadastre-se para visualizar as publicações!</h5></a>";
    } else {
        require './back-end/Conn.php';
        require './back-end/Publicacao.php';

        // Crie uma instância da classe Publicacao
        $publicacao = new Publicacao();

        // Obtenha as publicações
        $publicacoes = $publicacao->viewList();

        // Verifique se há publicações
        if (empty($publicacoes)) {
            echo "<h5 style='text-align: center; color: grey;'>Nenhuma postagem encontrada!</h5>";
        } else {
            // Exiba as publicações
            foreach ($publicacoes as $pub) {

                $nomeUsuario = $publicacao->getNome($pub['Usuario_usu_codigo']); // Usa a chave estrangeira
                echo "<div class='container'>
                <div style='border-radius: 20px;' class='col-md-12 bg-dark justify-content-center text-light p-3 m-2'>";
                echo "<h4><i class='bi bi-person'></i> " . $nomeUsuario . "</h4>";


                if ($pub['pub_titulo'] != null) {
                    echo "<h1 class='text-center' style='font-size: 40px;'>" . $pub['pub_titulo'] . "</h1><br>";
                }
                if ($pub['pub_descricao'] != null) {
                    echo "<p style='font-size: 20px;'>" . $pub['pub_descricao'] . "</p><br>";
                }
                if ($pub['pub_conteudo'] != null) {
                    echo "<img class='imagem d-block' style='margin: 0 auto; border-radius: 20px;' src='./upload/posts/" . $pub['pub_conteudo'] . "' alt='Arquivo da publicacao'><br>";
                }
                $dataF = new DateTime($pub['created']);
                $dataFormatada = $dataF->format('d/m/Y');

                echo "<i class='bi bi-clock'></i> Postado em " . $dataFormatada . " às " . $pub['hora'] . ".<br>";

                if ($_SESSION["usu_codigo"] == $pub['Usuario_usu_codigo']) {
                    echo "<a href=''>
                    <button class='btn btn-primary rounded-pill m-2' title='Editar publicação'>Editar</button>
                    </a>";

                }
                echo "</div>
                </div>";

            }
        }
    }

    ?>


    <button id="btnTopo" title="Voltar ao topo" class="btn btn-primary text-light rounded-pill"
        style="z-index: 99; bottom: 20px; right: 30px; position: fixed; display: none;">
        <i class="bi bi-chevron-up"></i>
    </button>



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