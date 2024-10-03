<?php
session_start();
include_once("../Servidor/conexion.php");

// Ejecución de la consulta y manejo de errores
$sql = "SELECT r.tipousu, COUNT(u.idtipo) as sum 
        FROM usuarios AS u 
        INNER JOIN tipousuarios AS r 
        ON u.idtipo = r.idtipo 
        GROUP BY u.idtipo";

$res = $conexion->query($sql);

if (!$res) {
    die("Error en la consulta SQL: " . $conexion->error);
}
?>
<html>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Tipos de usuario', 'Cantidad por tipo'],
            <?php
                $rows = [];
                while ($fila = $res->fetch_assoc()) {
                    $rows[] = "['" . $fila["tipousu"] . "'," . $fila["sum"] . "]";
                }
                echo implode(",", $rows); // Elimina la coma final
                ?>
        ]);

        var options = {
            title: 'TIPOS DE USUARIOS',
            width: 600,
            height: 400,
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
    </script>
</head>

<body>
    <!-- Agregando el encabezado-->
    <div class="container-fluid">
        <?php include_once("include/encabezado.php"); ?>
    </div>

    <div class="container" style="text-align: center;">
        <h2>INFORMACIÓN DE LOS USUARIOS</h2>
        <!--Div donde muestra el gráfico-->
        <div id="chart_div" style="width: 900px; height: 500px; padding-left: 300px;"></div>
    </div>
    <!-- Pie de página -->
    <div class="container-fluid">
        <?php include_once("include/pie.php"); ?>
    </div>
</body>

</html>