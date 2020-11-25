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
                    <p class="fc-color-fg-light-blue text-center" style="width: 200px; height: 7px; align-self: center; font-size: 18px;">Editar médico</p>
                </div>
            </div>
            <a></a>
        </nav>


        <div class="container mt-3" style="width: 500px;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <form action="../index.php?act=editarMedico" method="post" >


                            <div class="form-group <?php echo (!empty($medicotb->nome_msg)) ? 'has-error' : ''; ?>">
                                <label>Nome</label>
                                <input type="text" name="nome" class="form-control" value="<?php echo $medicotb->nome; ?>">
                                <span class="help-block"><?php echo $medicotb->nome_msg; ?></span>
                            </div>

                            <div class="form-group <?php echo (!empty($medicotb->email_msg)) ? 'has-error' : ''; ?>">
                                <label>Senha antiga</label>
                                <input type="password" name="senha_antiga" class="form-control" value="">
                                <span class="help-block"><?php echo $medicotb->email_msg; ?></span>
                            </div>

                            <div class="form-group <?php echo (!empty($medicotb->senha_msg)) ? 'has-error' : ''; ?>">
                                <label>Nova senha</label>
                                <input type="password" name="senha_nova" class="form-control" value="">
                                <span class="help-block"><?php echo $medicotb->senha_msg; ?></span>
                            </div>

                            <input type="hidden" name="id" value="<?php echo $medicotb->id; ?>"/>
                            <input type="submit" name="updatebtn" class="btn btn-primary" value="Atualizar">
                            <a href="../index.php" class="btn btn-default">Voltar para página inicial</a>
                        </form>
                    </div>
                </div>       
            </div>
        </div>
    </body>
</html>