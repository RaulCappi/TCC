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
    <link rel="stylesheet" href="/na-tabela/css/stylelogin.css">
    <link rel="stylesheet" href="/na-tabela/css/stylefonts.css">
    <style>
        .btn-entrar {
            border: 2px solid var(--d--color);
            color: var(--d--color);
            background: none;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;

        }

        .btn-entrar:hover {
            background-color: gray;
        }

        .montserrat {
            font-family: "Montserrat", sans-serif;
            font-optical-sizing: auto;
            font-weight: 700;
            font-style: normal;

        }
    </style>

    <title>Área Restrita</title>
</head>

<body calss="bg-light">
    <header class="cabecalho p-4" style="background-color: black;">

        <div class="cabl">
            <div class="logo">
                <a href="../index.php">
                    <img class="img" src="/na-tabela/img/1.png" alt="" width:="70px" height="70px">
                </a>
            </div>
        </div><!--Esquerda-->

        <div class="cabm" style="margin-right: rem;">
            <h1 class="montserrat">Na Tabela</h1>
        </div><!--Meio-->


        <div class="cabm">
            <ul class="nav nav-pills mb-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Listagens
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" class="dropdown-item">Usuarios</a>
                        </li>
                        <li>
                            <a href="./adm-list-posts.php" class="dropdown-item">Postagens</a>
                        </li>
                        <li>
                            <a href="./adm-list-atl.php" class="dropdown-item">Atletas</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="../logout.php" class="nav-link">Sair</a>
                </li>

            </ul>


        </div>

    </header><!--Cabeçalho-->

    <body>
        <?php
            require '../Conn.php';
            require '../Usuario.php';
        
        if (isset($_SESSION['msg_login'])) {
            echo "<div>" . $_SESSION['msg_login'] . "</div>";
            unset($_SESSION['msg_login']); 
        }

        if (isset($_SESSION['msg_usu_edit'])) {
            echo "<div>" . $_SESSION['msg_usu_edit'] . "</div>";
            unset($_SESSION['msg_usu_edit']);
        }

        if (isset($_SESSION['msg_usu_delete'])) {
            echo "<div>" . $_SESSION['msg_usu_delete'] . "</div>";
            unset($_SESSION['msg_usu_delete']); 
        }

        if (isset($_SESSION['msg_usu_ativo'])) {
            echo "<div>" . $_SESSION['msg_usu_ativo'] . "</div>";
            unset($_SESSION['msg_usu_ativo']); 
        }

        if (isset($_SESSION['msg_usu_perm'])) {
            echo "<div>" . $_SESSION['msg_usu_perm'] . "</div>";
            unset($_SESSION['msg_usu_perm']); 
        }

        $list = new Usuario();
        $result = $list->list();


        ?>

        <div class="container">
            <div class="row mt-4">
                <div class="col-lg-12 d-flex justify-content-between align-items-center">
                    <div>
                        <h2>Listar Usuários</h2>
                    </div>
                    <div>
                        <a href="../usu-create.php" class="btn btn-outline-success btn-sm">Cadastrar</a>
                    </div>
                </div>
            </div>
            <hr>

            <span id="msgAlerta"></span>

            <div class="row">
                <div class="col-lg-12">
                    <div class='table-responsive'>
                        <table class='table table-striped table-bordered' style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Foto</th>
                                    <th>Estado</th>
                                    <th>Cidade</th>
                                    <th>Permissão</th>
                                    <th>Ativo</th>
                                    <th>Created</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($result as $linha) {
                                    extract($linha);
                                    ?>
                                    <tr>
                                        <td><?php echo $usu_codigo; ?></td>
                                        <td><?php echo $usu_nome; ?></td>
                                        <td><?php echo $usu_email; ?></td>
                                        <td><?php echo $usu_telefone; ?></td>
                                        <td><?php echo $usu_foto; ?></td>
                                        <td><?php echo $usu_estado; ?></td>
                                        <td><?php echo $usu_cidade; ?></td>
                                        <td><?php echo $usu_publicar; ?></td>
                                        <td><?php echo $usu_ativo; ?></td>
                                        <?php
                                        $dataF = new DateTime($created);
                                        $dataFormatada = $dataF->format('d/m/Y');
                                        ?>
                                        <td><?php echo $dataFormatada; ?></td>
                                        </td>
                                        <td class="text-center">
                                            <a href="./adm-usu-view.php?id=<?php echo $usu_codigo; ?>"
                                                class='btn btn-outline-primary btn-sm'>Visualizar</a>

                                            <a href="../adm-usu-edit.php?id=<?php echo $usu_codigo; ?>"
                                                class="btn btn-outline-danger btn-sm">Editar</a>

                                            <a href="./adm-permitir.php?id=<?php echo $usu_codigo; ?>"
                                                class='btn btn-outline-warning btn-sm'>Permitir</a>

                                            <a href="./adm-ativar.php?id=<?php echo $usu_codigo; ?>"
                                                class="btn btn-outline-success btn-sm">Ativar</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
            </script>
        <script src="../js/funcao.js"></script>
    </body>

</html>