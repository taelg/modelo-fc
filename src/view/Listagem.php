<?php session_unset();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="~/../libs/fontawesome/css/font-awesome.css" rel="stylesheet" />    
    <link rel="stylesheet" href="~/../libs/bootstrap.css"> 
    <script src="~/../libs/jquery.min.js"></script>
    <script src="~/../libs/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <a href="index.php" class="btn btn-success pull-left">Home</a>
                        <h2 class="pull-left">Listagem de Médicos</h2>
                        <a href="view/cadastroMedico.php" class="btn btn-success pull-right">Registrar novo médico</a>
                    </div>
                    <?php
                        if($medicos->num_rows > 0){
                            
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";                                    
                                        echo "<th>Médico</th>";
                                        echo "<th>Açãos</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($medicos)){
                                    echo "<tr>";
                                        echo "<td>" . $row['nome'] . "</td>";     
                                        echo "<td>";
                                        echo "<a href='index.php?act=update&id=". $row['id'] ."' title='' data-toggle='tooltip'><i class='fa fa-edit'>Editar Cadastro</i></a>";
                                        echo "<a href='index.php?act=horarios&id=". $row['id'] ."' title='' data-toggle='tooltip'><i class='fa fa-trash'>Configurar Horários</i></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                    
                                    echo "<table class='table table-bordered table-striped'>";
                                        echo "<thead>";
                                            echo "<tr>";                     
                                                echo "<th>Data</th>";
                                                echo "<th>Disponível</th>";
                                            echo "</tr>";
                                        echo "</thead>";
                                        echo "<tbody>";
                                        
                                        foreach($dates as $subRow) {
                                            if($subRow['medid'] === $row['id']) {
                                                echo "<tr>";
                                                    echo "<td>" . $subRow['data'] . "</td>";                                   
                                                    echo "<td>" .($subRow['agendado']===0?"Sim":"Não")  . "</td>";
                                                echo "</tr>";
                                            }
                                        }
                                        echo "</tbody>";
                                    echo "</table>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                            
                            // Free result set
                            mysqli_free_result($medicos);
                            mysqli_free_result($dates);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>