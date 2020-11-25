<?php
require '../model/medico.php';
session_start();
$medicotb = isset($_SESSION['medicotbl0']) ? unserialize($_SESSION['medicotbl0']) : new medico();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <!-- Tael CSS -->
        <link rel="stylesheet" href="../model/css/style.css">
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Signika">
    </head>
    
    <body>
        <nav class="navbar navbar-dark fc-color-bg-light-blue">
            <a></a>
            <a></a>
            <a></a>
            <div class="d-flex justify-content-center" style="width: 250px; height: 70px;">
                <div class="badge bg-light d-flex justify-content-center" style="width: 200px; height: 48px; align-self: center;">
                    <p class="fc-color-fg-light-blue text-center" style="width: 200px; height: 7px; align-self: center; font-size: 18px;">Cadastro de Médico</p>
                </div>
            </div>
            <a></a>
        </nav>

        <div class="container mt-5">
            <div class="row justify-content-md-center">
                <div class="col-md-auto fc-color-bg-white">

                    <h1 class="container mt-4 col-md-auto fc-color-fg-dark-blue" style="width: 270px; font-size: 28px;"> Cadastro de médico </h1>

                    <div class="container mt-4 col-md-auto" style="width: 500px;">
                        <form action="../index.php?act=registrarMedico" method="post">

                            <div class="form-group my-4 <?php echo (!empty($medicotb->nome_msg)) ? 'has-error' : ''; ?>">
                                <label class="fc-color-fg-dark-blue my-n3" for="nome">Nome</label>
                                <input name="nome" type="text"  value="<?php echo $medicotb->nome; ?>" placeholder="Insira o nome do profissional" class="form-control">
                                <span class="help-block fc-color-fg-dark-blue"><?php echo $medicotb->nome_msg; ?></span>
                            </div>   

                            <div class="form-group my-4 <?php echo (!empty($medicotb->email_msg)) ? 'has-error' : ''; ?>">
                                <label class="fc-color-fg-dark-blue my-n3"  for="email">Email</label>
                                <input name="email" type="email" value="<?php echo $medicotb->email; ?>" placeholder="Exemplo@dominio.com.br" class="form-control" id="email">
                                <span class="help-block fc-color-fg-dark-blue"><?php echo $medicotb->email_msg; ?></span>
                            </div>

                            <div class="form-group my-4 <?php echo (!empty($medicotb->senha_msg)) ? 'has-error' : ''; ?>">
                                <label class="fc-color-fg-dark-blue my-n3"  for="password">Senha</label>
                                <input name="senha" type="password" value="<?php echo $medicotb->senha; ?>" placeholder="Escolha uma senha forte e segura" class="form-control" id="password">
                                <span class="help-block fc-color-fg-dark-blue"><?php echo $medicotb->senha_msg; ?></span>
                            </div>

                            <div class="container col-md-auto mt-5 form-group" style="width: 250px;">
                                <button type="submit" name="addbtn" value="Submit" class="btn fc-color-bg-light-blue fc-color-fg-white" style="width: 220px; height: 54px; font-size: 20px;">Realizar cadastro</button>
                            </div>

                            <div class="container mt-n2 col-md-auto form-group fc-color-fg-light-blue" style="width: 201px;">
                                <a href="../index.php" style="font-size: 15px;"> Voltar para a página inicial </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>