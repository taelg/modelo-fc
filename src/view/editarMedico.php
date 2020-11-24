<?php
        require '../model/medico.php'; 
        session_start();             
        $medicotb=isset($_SESSION['medicotbl0'])?unserialize($_SESSION['medicotbl0']):new medico();            
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="../libs/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Editar Médico</h2>
                    </div>
                    <form action="../index.php?act=update" method="post" >

                        
                        <div class="form-group <?php echo (!empty($medicotb->nome_msg)) ? 'has-error' : ''; ?>">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control" value="<?php echo $medicotb->nome; ?>">
                            <span class="help-block"><?php echo $medicotb->nome_msg;?></span>
                        </div>
                        
                        <div class="form-group <?php echo (!empty($medicotb->email_msg)) ? 'has-error' : ''; ?>">
                            <label>Senha antiga</label>
                            <input type="password" name="senha_antiga" class="form-control" value="">
                            <span class="help-block"><?php echo $medicotb->email_msg;?></span>
                        </div>
                        
                        <div class="form-group <?php echo (!empty($medicotb->senha_msg)) ? 'has-error' : ''; ?>">
                            <label>Nova senha</label>
                            <input type="password" name="senha_nova" class="form-control" value="">
                            <span class="help-block"><?php echo $medicotb->senha_msg;?></span>
                        </div>
                        
                        <input type="hidden" name="id" value="<?php echo $medicotb->id; ?>"/>
                        <input type="submit" name="updatebtn" class="btn btn-primary" value="Submit">
                        <a href="../index.php" class="btn btn-default">Voltar para página inicial</a>
                    </form>
                </div>
            </div>       
        </div>
    </div>
</body>
</html>