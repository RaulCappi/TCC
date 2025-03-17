<?php
session_start();
ob_start();
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empresa</title>
</head>

<body>
    <a href="index.php">Listar</a>
    <a href="create.php">Cadastrar</a>
    <h1 style="text-align: center;">Editar Empresa</h1>
    <?php
    require './Conn.php';
    require './Usuario.php';

    $formData = filter_input_array(INPUT_POST, FILTER_DEFAULT);


    if (!empty($formData['salvar'])) {
        $create = new Usuario();
        $create->formData = $formData;
        $valor = $create->edit();
        if ($valor) {
            $_SESSION['msg'] = "<h4 style='color: #00d10a; text-align: center'>Cadastro Realizado com Sucesso!</h4>";
            header("Location: index.php"); //Direciona para outra página
        } else {
            echo "<h4 style='color: #d10000; text-align: center'>Cadastro não Realizado!<h4>";
        }
    }

    if (!empty($id)) {
        $user = new Usuario();
        $user->id = $id;
        $row = $user->view();
        extract($row);


        ?>
        <div style="font-size: 20px; padding: 10px; text-align: center;">
            <form action="" method="post">

                <input type="text" id="id" name="id" value="<?php echo $idempresa ?>" readonly><br><br>
                <label for=""><strong>Título:</strong></label>
                <input type="text" id="titulo" name="titulo" placeholder="Digite o titulo da empresa" value="<?php echo $titulo ?>" required><br><br>

                <label for=""><strong>Descricao:</strong></label>
                <input type="text" id="descricao" name="descricao" placeholder="Digite a descrição da empresa" value="<?php echo $descricao ?>" required><br><br>

                <input type="submit" value="Salvar" name="salvar">
            </form>
        </div>
        <?php
    } else {
        $_SESSION['msg'] = "<p style='color: #d10000'>Registro não encontrado!</p>";
        header("Location: index.php"); //Direciona para outra página
    }
    ?>


</body>

</html>