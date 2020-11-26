<?php
require_once '../model/horario.php';
require_once '../model/medico.php';
session_start();
$medicotb = isset($_SESSION['medicotb10']) ? unserialize($_SESSION['medicotb10']) : new medico();
$horariotb = isset($_SESSION['horariotbl0']) ? unserialize($_SESSION['horariotbl0']) : new horario();
$dates = isset($_SESSION['datestb10']) ? unserialize($_SESSION['datestb10']) : null;
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
                    <p class="fc-color-fg-light-blue text-center" style="width: 200px; height: 7px; align-self: center; font-size: 18px;">Editar horários</p>
                </div>
            </div>
            <a></a>
        </nav>

        <div class="d-flex justify-content-start mt-5">

            <div class="container border" style="width: 400px;">
                <h2>Adicionar horários</h2>
                <form action="../index.php?act=registrarHorario" method="post">

                    <div class="form-group my-4">
                        <label class="fc-color-fg-dark-blue my-n3" for="nome">nome: </label>
                        <label><?php echo $medicotb->nome; ?> </label>
                        <input type='hidden' name='nome_medico' value='<?php echo $medicotb->nome; ?>'>
                        <input type='hidden' name='id_medico' value='<?php echo $medicotb->id; ?>'>
                    </div>


                    <div class="form-group my-4">
                        <label class="fc-color-fg-dark-blue my-n3"  for="datetime">data e hora</label>
                        <input type="datetime-local" name="data_horario" value="<?php echo $horariotb->data_horario; ?>" min="2020-01-01" max="2021-12-31">
                    </div>

                    <div class="form-group my-4">
                        <div class="container col-md-auto mt-5 form-group" style="width: 250px;">
                            <button type="submit" name="addHorario" class="btn fc-color-bg-light-blue fc-color-fg-white" value="Adicionar horário" style="width: 220px; height: 54px; font-size: 20px;">Adicionar horário</button>
                        </div>
                    </div>

                    <div class="container mt-n2 col-md-auto form-group fc-color-fg-light-blue" style="width: 201px;">
                        <a href="../index.php" style="font-size: 15px;"> Voltar para a página inicial </a>
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
                        foreach ($dates as $row) {
                            echo "<tr>";
                            echo "<td><a>" . $row['data'] . "</a></td>";
                            echo "<td><a href='../index.php?act=deletarHorario&id=" . $row['id'] . "&id_medico=" . $medicotb->id . "'>" . ($row['agendado'] === 0 ? "Excluir" : "") . "</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>