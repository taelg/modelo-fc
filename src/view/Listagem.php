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
        <link rel="stylesheet" type="text/css" href="../model/css/style.css">
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Signika">
    </head>

    <body>
        <nav class="navbar navbar-dark fc-color-bg-light-blue">
            <a></a>
            <a></a>
            <a></a>
            <div class="d-flex justify-content-center" style="width: 250px; height: 70px;">
                <div class="badge bg-light d-flex justify-content-center" style="width: 200px; height: 48px; align-self: center;">
                    <p class="fc-color-fg-light-blue text-center" style="width: 200px; height: 7px; align-self: center; font-size: 18px;">Listagem</p>
                </div>
            </div>
            <a></a>
        </nav>

        <div class="d-flex justify-content-center  mt-3">
            <a href="view/cadastroMedico.php" class="btn btn-success pull-right">Registrar novo médico</a>
        </div>
        
        <div class="container mt-3 border">
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
                    foreach ($dates as $subRow) {
                        if ($subRow['medid'] === $row['id']) {
                            echo "<tr>";
                            echo "<td><a class='fc-color-fg-light-blue' href='index.php?act=marcarHorario&id=" . $subRow['horid'] . "'  class='btn btn-default'>" . $subRow['data'] . "</a></td>";
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
    </body>
</html>