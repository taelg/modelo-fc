<?php session_unset(); ?>

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
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header clearfix">
                            <h2 class="pull-left">Listagem de Médicos</h2>
                            <a href="view/cadastroMedico.php" class="btn btn-success pull-right">Registrar novo médico</a>
                            <div class="container" style="height: 50px;"> </div>
                        </div>
                        <?php
                        if ($medicos->num_rows > 0) {

                            while ($row = mysqli_fetch_array($medicos)) {
                                echo "<h4> Médico: " . $row['nome'] . " </h4>";

                                echo "<a href='index.php?act=editarMedico&id=" . $row['id'] . "' title='' data-toggle='tooltip'><i class='fa fa-edit'>Editar Cadastro<br></i></a>";
                                echo "<a href='index.php?act=editarHorarios&id=" . $row['id'] . "' title='' data-toggle='tooltip'><i class='fa fa-trash'>Configurar Horários</i></a>";
                                echo "<table class='table table-bordered table-striped' style='width: 300px;'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>Data</th>";
                                echo "<th>Disponível</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";

                                //<a href="../index.php" class='btn btn-default'>Voltar para página inicial</a>
                                
                                
                                foreach ($dates as $subRow) {
                                    if ($subRow['medid'] === $row['id']) {
                                        echo "<tr>";
                                        echo "<td><a class='fc-color-bg-light-blue' href='index.php?act=registrarHorario&id=". $subRow['horid'] ."'  class='btn btn-default'>" . $subRow['data'] . "</a></td>";
                                        echo "<td>" . ($subRow['agendado'] === 0 ? "Sim" : "Não") . "</td>";
                                        echo "</tr>";
                                    }
                                }
                                echo "</tbody>";
                                echo "</table>";
                                echo "<div class='container' style='height: 50px;'> </div>";
                            }
                            echo "</tbody>";
                            echo "</table>";

                            // Free result set
                            mysqli_free_result($medicos);
                            mysqli_free_result($dates);
                        } else {
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                        ?>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>