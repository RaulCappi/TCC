<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/stylelogin.css">
    <link rel="stylesheet" href="../css/stylefonts.css">
    <style>
        .btn-entrar {
            border: 1px solid var(--d--color);
            color: var(--d--color);
            background: none;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s, color 0.3s;
        }

        .montserrat{
            font-family: "Montserrat", sans-serif;
            font-optical-sizing: auto;
            font-weight: 700;
            font-style: normal;

        }
    </style>

    <title>Cadastrar Usuário</title>
</head>

<body>
    <?php
    require './Conn.php';
    require './Usuario.php';

    $formData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($formData['cadastrar'])) {
        $create = new Usuario();
        $create->formData = $formData;
        $valor = $create->create();

        if ($valor) {
            $_SESSION['msg_cadastro'] =
                "<h5 style='color: green; text-align: center'>Registro realizado com sucesso!</h5>";
            header("Location: ../index.php"); //vai pra pagina que você quiser
        } else {
            echo "<h4 style='color: red; text-align: center'>Registro não realizado!</h4>";
        }

    }



    ?>
    <header class="cabecalho p-4" style="background-color: black;">

        <div class="cabl">
            <div class="logo">
                <a href="../index.php">
                    <img class="img" src="../img/1.png" alt="" width:="70px" height="70px">
                </a>
            </div>
        </div><!--Esquerda-->

        <div class="cabm" >
            <h1 class="montserrat">Na Tabela</h1>
        </div><!--Meio-->

        <div class="cabm">
            <button class="btn-entrar">
                <a href="usu-login.php" style="color: white; text-decoration: none;">Entrar</a>
            </button>

            <button class="btn-entrar">
                <a href="../index.php" style="color: white; text-decoration: none;">Voltar</a>
            </button>

        </div><!--Meio-->

    </header><!--Cabeçalho-->

    <div
        style="background-image: url('../img/basketball-black-3840x2160-17410.jpg'); width: 100%; height: 120%; background-size: cover;">
        <div class="container">

            <div style="margin-top: 7rem; border-radius: 1.5rem; background-color: rgba(255, 255, 255, 0.9); "
                class="col-lg-6 justify-content-center text-align-center position-absolute start-50 translate-middle top-50 p-3">
                
                <h1 style="text-align: center;">Bem-vindo(a) ao Na Tabela!</h1>
                <p class="d-none d-md-block" style="padding: 10px; text-align: center; font-size: 17px;">Aqui o basquete nunca para. Conecte-se e compartilhe suas
                    experiências!</p>


                <form class="form" method="post">
                    <span>Nome de usuário:</span><br>
                    <input type="text" name="nome" id="nome" style="color: black;" required
                        placeholder="Digite seu nome de usuário"><br>

                    <span>Email:</span><br>
                    <input type="email" name="email" id="email" style="color: black;" required
                        placeholder="Digite seu email"><br>

                    <span>Senha:</span><br>
                    <input type="password" name="senha" id="senha" style="color: black;" required
                        placeholder="Digite sua senha " style="">
                        
                    <i class="bi bi-eye-slash-fill position-absolute" onclick="togglePassword()" id="mostrarSenha"
                    style="cursor: pointer; right: 3rem; margin-top: 5px; font-size: 20px;"></i><br>

                    <span>Telefone:</span><br>
                    <input type="text" name="telefone" id="telefone" style="color: black;" required
                        placeholder="Digite seu telefone"><br>

                    <span>Cidade:</span><br>
                    <input type="text" name="cidade" id="cidade" style="color: black;" required
                        placeholder="Digite sua cidade"><br>



                    <button class="btnlogin" type="submit" value="Cadastrar" name="cadastrar"
                        style="color: white; margin-top: 10px;">CADASTRAR</button>

                </form><!--Login-->
            </div>

        </div>
    </div>

    <footer>
        <div style="background-color:rgb(30, 30, 30);" class="text-center justify-content-center p-5 text-light">
            <h5>Footer Footer Footer</h5>
            <p>FooterFooterFooterFooterFooterFooterFooterFooter</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
    <script src="../js/funcao.js"></script>
</body>

</html>