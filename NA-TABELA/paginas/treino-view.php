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
            background-color: ;
        }

        .btn {
            font-size: large;
        }

        .treinos {
            border: 2px, white, solid;
            font-size: 2.8rem;
            overflow-wrap: break-word;
            padding: 20px;
            border-radius: 15px;
            margin-top: 4rem;

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

                <a href="" class="btn" style="border: solid 1px white"><i class="bi bi-calendar4-week"></i>
                    Treinos</a><br>
                <a href="./time-view.php" class="btn"><i class="bi bi-file-person"></i> Equipe</a><br>

                <a href="./sobre.php" class="btn"><i class="bi bi-info-square"></i> Sobre o projeto</a><br>
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
            <h2 class="montserrat d-none d-md-block" style="color: white; margin-left: 3rem;">Treinos</h2>
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
                <li><a href='../paginas/usu-view.php?id=" . $_SESSION["usu_codigo"] . "' class='btn' style='color: gray;'><i class='bi bi-pencil-square'></i> Ver Perfil</a></li>
                <li><a href='../config/logout.php' class='btn' style='color: red;'><i class='bi bi-door-open text-danger'></i> Sair</a><br></li>
            </ul>
        </div>";

        }

        ?>
    </nav>
    <div class="text-center p-1" style=" height: 100vh;">

        <h1 class="montserrat text-white" style="border: 2px, white, solid; font-size: 2.8rem; overflow-wrap: break-word; padding: 20px;
            border-radius: 15px;">
            TREINOS SUB-12

        </h1>
        <div class="col-lg-12 mt-4 mb-4 p-4" style="height: auto; background-color: lightgrey;">
            <h1 class="montserrat" style="font-size: auto; overflow-wrap: break-word;">
                <strong>DIAS:</strong> TERÇA E QUINTA <br>
                <strong>HORÁRIO:</strong> 15H30 ÀS 17H
            </h1>

        </div>
        <h1 class="treinos montserrat text-white">
            TREINOS SUB-14 ATÉ SUB-21

        </h1>
        <div class="col-lg-12 mt-4 mb-4 p-4" style="height: auto; background-color: lightgrey;">
            <h1 class="montserrat" style="font-size: auto; overflow-wrap: break-word;">
                <strong>TODOS OS DIAS</strong> <br>
                TERÇA E QUINTA: 19H ÀS 20H30 <br><br>
                SEGUNDA, QUARTA E SEXTA: 18H ÀS 20H
            </h1>

        </div>
        <h1 class="treinos montserrat text-white">
            TREINOS ADULTO

        </h1>
        <div class="col-lg-12 mt-4 mb-4 p-4" style="height: auto; background-color: lightgrey;">
            <h1 class="montserrat" style="font-size: auto; overflow-wrap: break-word;">
                <strong>DIAS:</strong> TERÇA E QUINTA <br>
                <strong>HORÁRIO:</strong> 15H30 ÀS 17H
            </h1>


        </div>
        <h1 class="treinos montserrat text-white">
            LOCAL

        </h1>
        <div class="col-lg-12 mt-4 mb-4 p-4" style="height: auto; background-color: lightgrey;">
            <h1 class="montserrat" style="font-size: auto; overflow-wrap: break-word;">
                QUADRA DO COLÉGIO VENCESLAUENSE <br><br>
                Rua Piracicaba, 47 - Jardim Coroados - Pres. Venceslau
            </h1>


        </div>

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
                <a href="../config/adm/adm-login.php">
                <button class="btn btn-outline-light w-50"><i class="bi bi-person-circle"></i> Área Restrita</button>
                </a>
            </div>

        </div>
    </div>



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