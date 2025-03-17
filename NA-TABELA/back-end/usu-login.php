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

        .montserrat {
            font-family: "Montserrat", sans-serif;
            font-optical-sizing: auto;
            font-weight: 700;
            font-style: normal;

        }
    </style>

    <title>Login</title>
</head>

<body
    style="background-image: url('../img/basketball-black-3840x2160-17410.jpg'); width: 100%; height: 100%; background-size: cover;">
    <?php
    require './Conn.php';
    require './Usuario.php';

    $formData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($formData['entrar'])) {
        $login = new Usuario();
        $login->formData = $formData;

        if ($login->login()) {
            // Redireciona para a página principal ou dashboard
            $_SESSION['msg_login'] =
                "<h5 style='color: green; text-align: center'>Login realizado com sucesso!</h5>";
            header("Location: ../index.php");
            exit();
        } else {
            // Exibe mensagem de erro (login inválido)
            $_SESSION['msg_erro'] =
                "<h5 style='color: red; text-align: center'>Login ou senha incorretos!</h5>";
            //echo "<h5 style='color: red; text-align: center'>Login ou senha incorretos!</h5>";
        }


    }

    ?>


    <div class="">
        <header class="cabecalho p-4" style="background-color: black;">

            <div class="cabl">
                <div class="logo">
                    <a href="../index.php">
                        <img class="img" src="../img/1.png" alt="" width:="70px" height="70px">
                    </a>
                </div>
            </div><!--Esquerda-->

            <div class="cabm" style="margin-left: 3rem;">
                <h1 class="montserrat">Na Tabela</h1>
            </div><!--Meio-->

            <div class="cabm">
                <button class="btn-entrar">
                    <a href="usu-create.php" style="color: white; text-decoration: none;">Cadastre-se</a>
                </button>

                <button class="btn-entrar">
                    <a href="../index.php" style="color: white; text-decoration: none;">Voltar</a>
                </button>


            </div><!--Meio-->

        </header><!--Cabeçalho-->
        <div>
            <div class="container">
                <div style="border-radius: 1.5rem; background-color: rgba(255, 255, 255, 0.9); "
                    class="col-lg-6 justify-content-center text-align-center position-absolute top-0 start-50 translate-middle top-50 mt-5 p-4">

                    <h1 style="text-align: center;">Bem vindo de volta!</h1>
                    <p style="padding: 10px; text-align: center; font-size: 17px;">Aqui o basquete nunca para.
                        Conecte-se e compartilhe
                        suas
                        experiências!</p>


                    <form class="form" method="post">
                        <span>Nome de usuário:</span><br>
                        <input type="text" name="nome" id="nome" style="color: black;"
                            placeholder="Digite seu nome de usuário"><br>

                        <span>Email:</span><br>
                        <input type="email" name="email" id="email" style="color: black;"
                            placeholder="Digite seu email"><br>

                        <span>Senha:</span><br>
                        <input type="password" name="senha" id="senha" style="color: black;"
                            placeholder="Digite sua senha"><br>

                        <i class="bi bi-eye-slash-fill position-absolute" onclick="togglePassword()" id="mostrarSenha"
                            style="cursor: pointer; right: 3.5rem; bottom: 10.5rem; font-size: 20px;"></i><br>

                        <button class="btnlogin" type="submit" value="entrar" name="entrar"
                            style="color: white; margin-top: 10px;">Entrar</button>

                        <?php
                        if (isset($_SESSION['msg_erro'])) {
                            echo $_SESSION['msg_erro'];
                            unset($_SESSION['msg_erro']);
                        }

                        ?>


                    </form><!--Login-->

                    <div class="container d-flex justify-content-center">
                        <a href="usu-create.php" style="color: black;">Não possui uma conta? Cadastre-se aqui!</a>
                    </div>

                </div>
            </div>
        </div>

        <!-- <footer>
            <div class="bg-secondary text-center justify-content-center p-5">
                <h5>Footer Footer Footer</h5>
                <p>FooterFooterFooterFooterFooterFooterFooterFooter</p>
            </div>
        </footer> -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
            </script>
        <script src="../js/funcao.js"></script>
</body>

</html>