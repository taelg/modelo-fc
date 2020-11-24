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
                        <h2>Registrar Médico</h2>
                    </div>
                    <p>Preencha os campos e envie para adicionar um novo médico.</p>
                    <form action="../index.php?act=add" method="post" >
                        
                        <div class="form-group <?php echo (!empty($medicotb->nome_msg)) ? 'has-error' : ''; ?>">
                            <label>Nome do médico</label>
                            <input name="nome" class="form-control" value="<?php echo $medicotb->nome; ?>">
                            <span class="help-block"><?php echo $medicotb->nome_msg;?></span>
                        </div>
                        
                        <div class="form-group <?php echo (!empty($medicotb->email_msg)) ? 'has-error' : ''; ?>">
                            <label>Email do médico</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $medicotb->email; ?>">
                            <span class="help-block"><?php echo $medicotb->email_msg;?></span>
                        </div>
                        
                        <div class="form-group <?php echo (!empty($medicotb->senha_msg)) ? 'has-error' : ''; ?>">
                            <label>Senha do médico</label>
                            <input type="password" name="senha" class="form-control" value="<?php echo $medicotb->senha; ?>">
                            <span class="help-block"><?php echo $medicotb->senha_msg;?></span>
                        </div>
                        
                        <input type="submit" name="addbtn" class="btn btn-primary" value="Submit">
                        <a href="../index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>