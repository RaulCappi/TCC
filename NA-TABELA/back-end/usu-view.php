<?php
session_start();
ob_start();
//receber o id do usuario vindo do home
//$id = filter_input()
//ou
$id = $_GET['id'];

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vizualizar</title>
</head>

<body>
    <a href="index.php">Listar</a>
    <a href="create.php">Cadastrar</a>
    <h1 style="text-align: center;">Detalhes da Empresa</h1>

    <div style="text-align: center; font-size: 22px; margin-top: 100px; line-height: 35px;">

    <?php
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);

    }
    //Verificar se id possui valor
    if (!empty($id)) {
        //incluir arquivos
        require './Conn.php';
        require './Empresa.php';

        //instanciar e criar obj
        $view = new Usuario();
        //enviando id para o atributo id de User
        $view->id = $id;
        //instanciando o método visualizar/view
        $valor = $view->view();

        extract($valor);
        echo "<tr>";
        echo "<strong>ID da Empresa:</strong> $idempresa <br>";
        echo "<strong>Título da Empresa:</strong> $titulo <br>";
        echo "<strong>Descrição da Empresa:</strong> $descricao <br>";

        
        $dataF = new DateTime($created_at);
        $dataFormatada = $dataF->format('d/m/Y H:i:s');
        echo "<strong>Cadastrado:</strong> $dataFormatada <br>";
        //echo "<td>$dataFormatada</td>";
    
    } else {
        $_SESSION['msg'] = "<p style='color: #f00'>
                Erro: Registro não encontrado
                </p>";
        header('Location: index.php');
    }


    ?>
    </div>

</body>

</html>