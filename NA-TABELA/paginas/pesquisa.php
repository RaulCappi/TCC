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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
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
                <a href="../index.php" class="btn"><i class="bi bi-house"></i>
                    Página inicial</a><br>

                <a href="./treino-view.php" class="btn"><i class="bi bi-calendar4-week"></i> Treinos</a><br>
                <a href="./time-view.php" class="btn"><i class="bi bi-file-person"></i> Equipe</a><br>

                <a href="./paginas/sobre.php" class="btn" style="border: solid 1px white"><i
                        class="bi bi-info-square"></i> Sobre o projeto</a><br>
                <?php
                if (isset($_SESSION["usu_codigo"])) {
                    echo '<a href="../config/pub-create.php">
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

        <div>
            <h2 class="montserrat d-none d-md-block" style="color: white; margin-left: 3rem;">SOBRE O PROJETO</h2>
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
            require '../config/Conn.php';
            require '../config/Usuario.php';
            $foto = new Usuario();

            $foto->id = $_SESSION["usu_codigo"];
            $valor = $foto->viewFoto();

            extract($valor);

            if ($usu_foto == null) {
                $usu_foto = "padrao.jpg";
            }

            echo "<div class='nav-item dropdown'>
            <a class='nav-link text-light' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
            
                <h4 style='color: white;'><img class='imagem-perfil rounded-pill' src='../upload/perfil/" . $usu_foto . "' alt=''> " . $_SESSION["usu_nome"] . " <i class='bi bi-caret-down-fill'></i></h4>
            </a> 
            <ul class='dropdown-menu text-center'>
                <li><a href='./usu-view.php?id=" . $_SESSION["usu_codigo"] . "' class='btn' style='color: gray;'><i class='bi bi-pencil-square'></i> Ver Perfil</a></li>
                <li><a href='../config/logout.php' class='btn' style='color: red;'><i class='bi bi-door-open text-danger'></i> Sair</a><br></li>
            </ul>
        </div>";
        }

        ?>
    </nav>

    <?php
    require '../config/Publicacao.php';

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Verifica se o campo 'termo_busca' foi enviado
        if (isset($_GET["busca"])) {
            $termo = $_GET["busca"];

            $pesquisa = new Publicacao();


            $valor = $pesquisa->pesquisarPub($termo);

            if (empty($valor)) {
                echo "<h5 style='text-align: center; color: grey;'>Nenhuma postagem encontrada!</h5>";
            } else {
                // Exiba as publicações
                foreach ($valor as $pub) {

                    $nomeAutor = $pesquisa->getNome($pub['Usuario_usu_codigo']);
                    $fotoAutor = $pesquisa->getFoto($pub['Usuario_usu_codigo']);
                    // Usa a chave estrangeira
                    if ($fotoAutor == null) {
                        $fotoAutor = "padrao.jpg";
                    }
                    
                    echo "<div class='container mt-4'>
                    <div style='border: 3px solid white; border-radius: 20px;'>
                    <a href='./pub-view.php?id=" . $pub['pub_codigo'] . "' style='text-decoration: none; color: white;'>
                    <div style='border-radius: 20px;' class='position-item col-md-12 bg-dark justify-content-center text-light p-3' onclick='./paginas/pub-view.php'>";
                    echo "<h4 class='m-2'><img class='imagem-perfil rounded-pill' src='../upload/perfil/" . $fotoAutor . "' alt=''> " . $nomeAutor . "</h4>";

                    if ($pub['pub_titulo'] != null) {
                        echo '
                        <h1 class="poppins-bold text-center" style="font-size: 40px; font-family: ">' . $pub['pub_titulo'] . '</h1><br>';
                    }

                    $dataF = new DateTime($pub['created']);
                    $dataFormatada = $dataF->format('d/m/Y');

                    echo "<i class='bi bi-clock'></i> Postado em " . $dataFormatada . " às " . $pub['hora'] . ".<br>";

                    echo "</a>
                    </div>
                    </div>
                    </div>";

                }

            }
        }
    }

    ?>
    <div class="text-center">
        <a href="../index.php">
            <button class="btn btn-danger rounded-pill mt-3 mb-3" style="font-size: 20px; width: 50%;">Voltar</button>
        </a>
    </div>
    <button id="btnTopo" title="Voltar ao topo" class="btn btn-primary text-light rounded-pill"
        style="z-index: 99; bottom: 20px; right: 30px; position: fixed; display: none;"><i
            class="bi bi-chevron-up"></i></button>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>

    <script>
        let btnTopo = document.getElementById("btnTopo");

        // Exibe o botão quando o usuário rola para baixo 20px da parte superior da página
        window.onscroll = function () {
            scrollFunction()
        };

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