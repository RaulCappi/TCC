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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@500;700;800&display=swap" rel="stylesheet">
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

        .position-item {
            transition: transform 0.15s ease-in-out;
            /* Adiciona uma transição suave na propriedade transform */
        }

        .position-item:hover {
            transform: scale(1.03);
            /* Aumenta a escala do elemento em 5% no hover */
            cursor: pointer;
            /* Opcional: muda o cursor para indicar que é interativo */

        }

        .botao-pub:hover {
            background-color: gray;
            color: white;

        }
    </style>
</head>

<body style="
<?php
if (isset($_SESSION["usu_codigo"])) {
    echo 'background-color: black;';

} else {
    echo 'background-color:rgb(238, 238, 238);';
}

?>">

    <nav class="navbar">
        <a class="btn" data-bs-toggle="offcanvas" href="#menu-lateral">
            <i style="font-size: 25px;" class="bi bi-list text-light"></i></a>

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
                <a href="./paginas/treino-view.php" class="btn"><i class="bi bi-calendar4-week"></i> Treinos</a><br>
                <a href="./paginas/time-view.php" class="btn"><i class="bi bi-file-person"></i> Equipe</a><br>
                <a href="./paginas/sobre.php" class="btn"><i class="bi bi-info-square"></i> Sobre o projeto</a><br>
                <?php
                if (isset($_SESSION["usu_codigo"])) {
                    echo '<a href="./config/pub-create.php">
                    <button class="botao-pub btn btn-light rounded-pill p-2 w-75" style="font-weight: bold;">Publicar</button>
                </a>';
                }
                ?>

            </div>
        </div>

        <div class="">
            <img class="img" src="img/1.png" alt="" width:="70px" height="70px">
        </div>

        <?php
        require './config/Conn.php';
        require './config/Usuario.php';
        require './config/Publicacao.php';


        if (isset($_SESSION["usu_codigo"])) {

            $formData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            echo '
            <form class="form d-flex align-items-center" method="get" action="./paginas/pesquisa.php">
            <input type="text" name="busca" placeholder="Pesquise uma publicação"
                style="width: 22rem; height: 35px; text-align: center; border-radius: 20px; border: none;">
            
                <button class="btn-entrar d-none d-md-block" type="submit" value="Pesquisar" name="pesquisar"
                style="color: white; margin-left: 7rem;"><i class="bi bi-search"></i></button>


        </form>';

        }



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

            $foto = new Usuario();

            $foto->id = $_SESSION["usu_codigo"];
            $valor = $foto->viewFoto();

            extract($valor);

            if ($usu_foto == null) {
                $usu_foto = "padrao.jpg";
            }

            echo "<div class='nav-item dropdown'>
            <a class='nav-link text-light' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
            
                <h4 style='color: white;'><img class='imagem-perfil rounded-pill' src='./upload/perfil/" . $usu_foto . "' alt=''> " . $_SESSION["usu_nome"] . " <i class='bi bi-caret-down-fill'></i></h4>
            </a> 
            <ul class='dropdown-menu text-center'>
                <li><a href='./paginas/usu-view.php?id=" . $_SESSION["usu_codigo"] . "' class='btn' style='color: gray;'><i class='bi bi-pencil-square'></i> Ver Perfil</a></li>
                <li><a href='./config/logout.php' class='btn' style='color: red;'><i class='bi bi-door-open text-danger'></i> Sair</a><br></li>
            </ul>
        </div>";
            // Exibir conteúdo para usuários logados
        
        }

        ?>
    </nav>
    <?php



    $postsPorPagina = 4;
    $publi = new Publicacao();

    $paginaAtual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
    $paginaAtual = max(1, $paginaAtual);
    $totalPaginas = $publi->numeroTotalPaginas($postsPorPagina);
    $paginaAtual = min($paginaAtual, $totalPaginas);

    $publiPaginadas = $publi->publicaoesPaginadas($paginaAtual, $postsPorPagina);

    $links = 2;

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

    if (isset($_SESSION['msg_pub_edit'])) {
        echo "<div>" . $_SESSION['msg_pub_edit'] . "</div>";
        unset($_SESSION['msg_pub_edit']);
    }

    if (isset($_SESSION['msg_usu_edit'])) {
        echo "<div>" . $_SESSION['msg_usu_edit'] . "</div>";
        unset($_SESSION['msg_usu_edit']);
    }

    if (isset($_SESSION['msg_usu_delete'])) {
        echo "<div>" . $_SESSION['msg_usu_delete'] . "</div>";
        unset($_SESSION['msg_usu_delete']);
    }

    if (isset($_SESSION['msg_pub_delete'])) {
        echo "<div>" . $_SESSION['msg_pub_delete'] . "</div>";
        unset($_SESSION['msg_pub_delete']);
    }


    if (!isset($_SESSION["usu_codigo"])) {
        echo '
           <div class="text-center p-5">
            <a class="text-dark" href="./config/usu-login.php" style="">
            <h1 class="montserrat" style="font-size: 2.8rem; overflow-wrap: break-word;">
                FAÇA LOGIN OU CADASTRE-SE
                PARA VISUALIZAR AS PUBLICAÇÕES!

            </h1>
        </a>
        <img src="./img/1.png" class="imagem mb-5" alt="">
        

    </div>';
    } else {

        // Crie uma instância da classe Publicacao
        $publicacao = new Publicacao();

        // Obtenha as publicações
        $publicacoes = $publicacao->publicaoesPaginadas($paginaAtual, $postsPorPagina);

        // Verifique se há publicações
        if (empty($publicacoes)) {
            echo "<h5 style='text-align: center; color: grey;'>Nenhuma postagem encontrada!</h5>";
        } else {
            // Exiba as publicações
            foreach ($publicacoes as $pub) {

                $nomeAutor = $publicacao->getNome($pub['Usuario_usu_codigo']);
                $fotoAutor = $publicacao->getFoto($pub['Usuario_usu_codigo']);
                // Usa a chave estrangeira
                if ($fotoAutor == null) {
                    $fotoAutor = "padrao.jpg";
                }


                echo "<div class='container'>
                <a href='./paginas/pub-view.php?id=" . $pub['pub_codigo'] . "' style='text-decoration: none; color: white;'>
                <div style='border-radius: 20px;' class='position-item col-md-12 bg-dark justify-content-center text-light p-3 m-2' onclick='./paginas/pub-view.php'>";
                echo "<h4 class='m-2'><img class='imagem-perfil rounded-pill' src='./upload/perfil/" . $fotoAutor . "' alt=''> " . $nomeAutor . "</h4>";


                if ($pub['pub_titulo'] != null) {
                    echo "<h1 class='poppins-bold text-center' style='font-size: 40px; font-family: '>" . $pub['pub_titulo'] . "</h1><br>";
                }
                if ($pub['pub_descricao'] != null) {
                    echo "<p style='font-size: 20px; margin-left: 20px; overflow-wrap: break-word;'>" . $pub['pub_descricao'] . "</p><br>";
                }
                if ($pub['pub_conteudo'] != null) {
                    echo "<img class='imagem d-block' style='margin: 0 auto; border-radius: 20px;' src='./upload/posts/" . $pub['pub_conteudo'] . "' alt='Arquivo da publicacao'><br>";
                }
                $dataF = new DateTime($pub['created']);
                $dataFormatada = $dataF->format('d/m/Y');

                echo "<i class='bi bi-clock'></i> Postado em " . $dataFormatada . " às " . $pub['hora'] . ".<br>";

                if ($pub['modified'] != null && $pub['hora_modif'] != null) {
                    $dataF = new DateTime($pub['modified']);
                    $dataFormatada = $dataF->format('d/m/Y');

                    echo "<i class='bi bi-box-arrow-up'></i> Atualizado em " . $dataFormatada . " às " . $pub['hora_modif'] . ".<br>";
                }

                echo "</a>
                </div>
                </div>";

            }
        }
    }

    echo '<div class="container-fluid">';
    echo '<nav class="text-center row container-fluid position-relative bottom-0 m-2">';
    echo '<ul class="pagination justify-content-center d-flex flex-row">';

    if (isset($_SESSION["usu_codigo"])) {
        // Link para a primeira página
        if ($paginaAtual > 1) {
            echo "<li class='page-item'><a class='page-link' href='?pagina=1' aria-label='Página Inicial'><span aria-hidden='true'>&laquo;</span></a></li>";
        }

        // Links para as páginas anteriores
        for ($i = $paginaAtual - $links; $i < $paginaAtual; $i++) {
            if ($i > 0) {
                echo "<li class='page-item'><a class='page-link' href='?pagina=" . $i . "'>" . $i . "</a></li>";
            }
        }

        // Página atual
        echo "<li class='page-item active'><span class='page-link'>" . $paginaAtual . "</span></li>";

        // Links para as próximas páginas
        for ($i = $paginaAtual + 1; $i <= $paginaAtual + $links; $i++) {
            if ($i <= $totalPaginas) {
                echo "<li class='page-item'><a class='page-link' href='?pagina=" . $i . "'>" . $i . "</a></li>";
            }
        }

        // Link para a última página
        if ($paginaAtual < $totalPaginas) {
            echo "<li class='page-item'><a class='page-link' href='?pagina=" . $totalPaginas . "' aria-label='Última página'><span aria-hidden='true'>&raquo;</span></a></li>";
        }


    }

    echo '</ul>';
    echo '</nav>';
    echo '</div>';


    ?>
    <div class="bg-dark text-light text-center justify-content-evenly p-5 d-flex flex-column"
        style=" overflow-wrap: break-word; font-weight: bold;">
        <div class="row">
            <div class="col-6">

                <p>NA TABELA - 2025</p>
                <p>TCC - ETEC MILTON GAZZETTI</p>

            </div>
            <div class="col-6">

                <p>BASQUETE ABPV</p>
                <p>PRESIDENTE VENCESLAU</p>

            </div>
        </div>
        <div class="text-center">
            <p>Todos os Direitos Reservados</p>
            <a href="./config/adm/adm-login.php">
                <button class="btn btn-outline-light w-50"><i class="bi bi-person-circle"></i> Área Restrita</button>
            </a>
        </div>

    </div>

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