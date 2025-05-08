<?php
session_start();
ob_start();
$id = $_GET['id'];
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
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Na Tabela</title>

    <style>
        .btn:hover {
            color: grey;
        }

        .btn {
            font-size: large;
        }

        .botoes-editS button {
            border: 1px solid white;
            color: white;
            background-color: black;
            padding: 10px;
        }

        .botoes-editS button:hover {
            background-color: green;
            color: white;
            border: 2px solid white;
        }


        .form input {
            border: 2px solid gray;
            height: 60px;
            background-color: white;
        }

        .form textarea {
            border: solid gray;
            background-color: white;
        }

        label {
            font-size: 30px;
            font-weight: bold;
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
                <a href="../paginas/time-view.php" class="btn"><i class="bi bi-file-person"></i> Equipe</a><br>
                <a href="../paginas/sobre.php" class="btn"><i class="bi bi-info-square"></i> Sobre o projeto</a><br>
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

        <div>
            <h2 class="montserrat d-none d-md-block" style="color: white; margin-left: 3rem;">EDITAR PUBLICAÇÃO</h2>
        </div>

        <div></div>

        <?php
     
            require '../config/Conn.php';
            require '../config/Usuario.php';

        ?>
    </nav>
    <?php
    require '../config/Publicacao.php';

    $formData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!isset($_SESSION['adm_codigo'])) {
        echo "<div class='container'>
        <div style='border-radius: 20px;' class='position-item col-md-12 bg-dark justify-content-center text-light p-3 m-2'>";
        echo '<h1 class="text-center">FAÇA LOGIN PARA EDITAR A PUBLICAÇÃO</h1>';

        echo "</div>
        </div>";

    }
    if (!empty($formData['salvar'])) {
        //incluir arquivos
    
        $edit = new Publicacao();
        $edit->id = $id;
        $edit->formData = $formData;
        $arquivo = null;
        // $valor = $edit->edit();
    
        if (isset($formData['remover-imagem']) && $formData['remover-imagem'] == 1) {
            $detalhesPublicacao = $edit->viewIndividual();

            if ($detalhesPublicacao && !empty($detalhesPublicacao['pub_conteudo'])) {
                $nomeArquivoAntigo = $detalhesPublicacao['pub_conteudo'];
                $caminhoArquivoAntigo = '../upload/posts/' . $nomeArquivoAntigo;

                if (file_exists($caminhoArquivoAntigo)) {
                    unlink($caminhoArquivoAntigo);
                    // Opcional: Atualizar o campo pub_conteudo no banco para NULL
                    $edit->editConteudo(null, $id);
                }
            }

        }

        // Lógica para o upload da nova imagem (se um arquivo foi selecionado)
        if (isset($_FILES['conteudo']) && $_FILES['conteudo']['error'] == UPLOAD_ERR_OK) {

            $uploaddir = '../upload/posts/';
            $nome_arquivo = uniqid() . "_" . $_FILES['conteudo']['name'];
            $caminho_completo = $uploaddir . $nome_arquivo;

            if (move_uploaded_file($_FILES['conteudo']['tmp_name'], $caminho_completo)) {
                $arquivo = $nome_arquivo;
                // Atualizar o campo pub_conteudo no banco com o novo nome do arquivo
                $edit->editConteudo($arquivo, $id);

            } else {
                echo "<h4 style='color: red; text-align: center'>Erro ao mover o novo arquivo para o servidor!</h4>";
            }
        } else if (isset($_FILES['conteudo']) && $_FILES['conteudo']['error'] != UPLOAD_ERR_NO_FILE) {
            echo "<h4 style='color: red; text-align: center'>Erro no upload do novo arquivo: " . $_FILES['conteudo']['error'] . "</h4>";
        }

        // Atualizar os outros campos (título e descrição)
        $valor = $edit->edit();

        if ($valor) {
            $_SESSION['msg_pub_edit'] = "<h4 style='color: #00d10a; text-align: center'>Edição Realizada com Sucesso!</h4>";
            header("Location: ./adm/adm-list-posts.php"); //Direciona para outra página
        } else {
            echo "<h4 style='color: #d10000; text-align: center'>Edição não Realizada!<h4>";
        }

    }
    if (!empty($id)) {


        //instanciar e criar obj
        $view = new Publicacao();
        //enviando id para o atributo id de User
        $view->id = $id;
        //instanciando o método visualizar/view
        $valor = $view->viewIndividual();

        extract($valor);



        echo "
        <div class='container-fluid'>
        <div style='border-radius: 20px;' class='position-item text-center col-md-12 bg-dark justify-content-center text-light p-4 m-2' >
        <form class='form' method='post' enctype='multipart/form-data'>";

        $nomeAutor = $view->getNome($Usuario_usu_codigo);

        if (!isset($_SESSION['adm_codigo'])) {
            echo '<h2>Acesso negado</h2>';
            exit();
        }

        echo "<h2 class='text-start mb-5'><i class='bi bi-person'></i> " . $nomeAutor . "</h2>";

        echo '
        <label>TÍTULO</label>
        <h3 style="font-size: 30px; margin-left: 15px;"><input class="mb-5" type="text" name="titulo" id="titulo" style="color: black;" value="' . $pub_titulo . '"> </h3><br>';

        echo '
        <label>DESCRIÇÃO</label>
        <p style="font-size: 20px; margin-left: 1rem;"><textarea name="descricao" id="descricao" style="color: black;" rows="5" cols="50"
            placeholder="Digite a descrição da publicação">' . $pub_descricao . '</textarea></p><br>';


        if (!empty($pub_conteudo)) {
            echo '
        <label>IMAGEM ORIGINAL</label><br>  
        <img src="../upload/posts/' . $pub_conteudo . '" alt="Arquivo da Publicação" class="imagem"><br>';

            echo '<label for="remover_imagem">Remover imagem atual</label>
            <input type="checkbox" name="remover-imagem" id="remover-imagem" style="height: 30px;"   value="1"> ';
        }


        echo '<h4><input type="file" name="conteudo" id="conteudo" class="m-3"></h4>';

        echo '<div class="botoes-editS text-center">
        <button class="btn btn-success rounded-pill m-5 p-4" style="font-size: 20px; width: 40%;" type="submit" value="Salvar" name="salvar">Salvar</button>
        </div>';


    } else {
        echo "<h1 style='color: #f00'>
                Erro: Registro não encontrado
                </h1>";
    }
    echo "
        </form>
        </div>
        </div>";

    ?>

    <div class=" text-center">
        <a href="./adm/adm-list-posts.php">
            <button class="btn btn-danger rounded-pill mt-3 mb-3 p-3"
                style="font-size: 20px; width: 40%; margin-left: 1vw;">Voltar</button>
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

        const textarea = document.getElementById('descricao');
        const valueDescricao = document.getElementById('valueDescricao');

        // Obter o valor atual
        textarea.value = valueDescricao.value

    </script>
</body>

</html>