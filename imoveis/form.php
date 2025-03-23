<?php
if (isset($_POST['submit'])) {
    include_once('config.php');

    if (isset($_FILES['img'])) {
        $error = $_FILES['img']['error'];
        if ($error == UPLOAD_ERR_OK) {
            $img = $_FILES['img']['name'];
            $uploadDir = 'uploads/';
            
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); 
            }

            $uploadFile = $uploadDir . basename($img);
            $ext = pathinfo($img, PATHINFO_EXTENSION);
            $extPermitidas = array('jpg', 'jpeg', 'png', 'gif'); 

            if (!in_array(strtolower($ext), $extPermitidas)) {
                echo "<script>alert('Tipo de arquivo não permitido!'); window.location.href='form.php';</script>";
                exit;
            }

            if (!move_uploaded_file($_FILES['img']['tmp_name'], $uploadFile)) {
                echo "<script>alert('Erro ao fazer upload da imagem!'); window.location.href='form.php';</script>";
                exit;
            }
        } else {
            switch ($error) {
                case UPLOAD_ERR_INI_SIZE:
                    echo "<script>alert('Arquivo muito grande!'); window.location.href='form.php';</script>";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    echo "<script>alert('O arquivo ultrapassa o limite especificado no formulário!'); window.location.href='form.php';</script>";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo "<script>alert('O upload do arquivo foi feito parcialmente!'); window.location.href='form.php';</script>";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "<script>alert('Nenhum arquivo foi enviado!'); window.location.href='form.php';</script>";
                    break;
                default:
                    echo "<script>alert('Erro desconhecido no upload!'); window.location.href='form.php';</script>";
            }
            exit;
        }
    } else {
        $img = ''; 
    }

    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $cep = mysqli_real_escape_string($conexao, $_POST['cep']);
    $loc = mysqli_real_escape_string($conexao, $_POST['loc']);
    $estado = mysqli_real_escape_string($conexao, $_POST['estado']);
    $TempoDeCompra = mysqli_real_escape_string($conexao, $_POST['TempoDeCompra']);

    $query = "INSERT INTO Imoveis (img, nome, cep, loc, estado, TempoDeCompra)
              VALUES ('$img', '$nome', '$cep', '$loc', '$estado', '$TempoDeCompra')";

    if (mysqli_query($conexao, $query)) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='form.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar!'); window.location.href='form.php';</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<script src="form.js"></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de imoveis</title>
</head>
<style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px;
        }

        h1 {
            margin: 0;
        }

        /* Form Styles */
        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"], input[type="file"], input[type="submit"], input[type="checkbox"] {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        input[type="checkbox"] {
            width: auto;
            display: inline-block;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            width: auto;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            form {
                padding: 15px;
                width: 90%;
            }
        }

        @media (max-width: 480px) {
            input[type="text"], input[type="file"], input[type="submit"] {
                width: 100%;
            }
        }

        /* Checkbox container */
        div {
            margin-bottom: 10px;
        }

    </style>
<body>

<header>
<h1>Cadastro de Imóvel</h1>
</header>

<form action="form.php" method="POST" enctype="multipart/form-data">
    <label for="img">Imagem do Imóvel:</label><br>
    <input type="file" id="img" name="img"><br><br>
    

    <label for="nome">Nome do Imóvel:</label><br>
    <input type="text" id="nome" name="nome"><br><br>

    <label for="cep">CEP(inclua "-"):</label><br>
    <input type="text" id="cep" name="cep" maxlength="9" ><br><br>

    <label for="loc">Endereço:</label><br>
    <input type="text" id="loc" name="loc"><br><br>

    <div>
        <label for="estado">Condição do Imóvel:</label><br>
        <input type="checkbox" id="estado" name="estado" value="Novo" onclick="selectOnlyThis(this)" name="fooby[1][]"/>   Novo<br><br>
        <input type="checkbox" id="estado" name="estado" value="Bom" onclick="selectOnlyThis(this)" name="fooby[1][]"/>   Bom <br><br>
        <input type="checkbox" id="estado" name="estado" value="Danificado" onclick="selectOnlyThis(this)" name="fooby[1][]"/>   Danificado<br><br>
    <div>

    <label for="TempoDeCompra">Tempo de compra:</label><br>
    <input type="text" id="TempoDeCompra" name="TempoDeCompra"><br><br>
    
   <input type="submit" name="submit" id="submit" value="enviar">
</form>
    
</body>
</html>