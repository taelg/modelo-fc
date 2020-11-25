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
        <nav class="navbar navbar-dark fc-color-bg-light-blue">
            <a></a>
            <a></a>
            <a></a>
            <div class="d-flex justify-content-center" style="width: 250px; height: 70px;">
                <div class="badge bg-light d-flex justify-content-center" style="width: 200px; height: 48px; align-self: center;">
                    <p class="fc-color-fg-light-blue text-center" style="width: 200px; height: 7px; align-self: center; font-size: 18px;">Editar horários</p>
                </div>
            </div>
            <a></a>
        </nav>

        <div class="d-flex justify-content-start mt-5">

            <?php $medico = mysqli_fetch_array($medicos); ?>
            <div class="container border" style="width: 400px;">
                <h2>Adicionar horários</h2>
                <form action="../index.php?act=registrarMedico" method="post">

                    <div class="form-group my-4">
                        <label class="fc-color-fg-dark-blue my-n3" for="nome">nome:</label>
                        <?php echo "<h3>" . $medico['nome'] . "</h3>" ?>
                    </div>

                    <div class="form-group my-4">
                        <label class="fc-color-fg-dark-blue my-n3"  for="datetime">data e hora</label>
                        <input type="datetime-local" name="horario" min="2020-01-01" max="2021-12-31">
                    </div>

                    <div class="form-group my-4">
                        <div class="container col-md-auto mt-5 form-group" style="width: 250px;">
                            <button type="submit" name="addhorario" class="btn fc-color-bg-light-blue fc-color-fg-white" value="Adicionar horário" style="width: 220px; height: 54px; font-size: 20px;">Adicionar horário</button>
                        </div>
                    </div>

                    <div class="container mt-n2 col-md-auto form-group fc-color-fg-light-blue" style="width: 201px;">
                        <a href="index.php" style="font-size: 15px;"> Voltar para a página inicial </a>
                    </div>
                </form>
            </div>

            <div class="container border" style="width: 400px;">
                <h2>Horários configurados</h2>
                <table class='table table-bordered table-striped' style='width: 300px;'>
                    <thead>
                        <tr>
                            <th>Horário</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>                
                        <?php
                        if ($dates->num_rows > 0) {
                            while ($row = mysqli_fetch_array($dates)) {
                                echo "<tr>";
                                echo "<td><a>" . $row['data'] . "</a></td>";
                                echo "<td>" . ($row['agendado'] === 0 ? "Excluir" : "") . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                        // Free result set
                        mysqli_free_result($medicos);
                        mysqli_free_result($dates);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>