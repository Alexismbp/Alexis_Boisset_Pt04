<!-- Alexis Boisset -->
<?php
// Inclou el controlador per obtenir la llista d'elements
include "../controlador/list.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Articles</title>
    <link rel="stylesheet" href="../styles/styles_llistar.css">
</head>

<body>
    <h1>Lista d'articles</h1>
    <div class="table-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Descripció</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Obtenir les files d'articles
                $files = solicitudRows();

                // Recórrer i mostrar cada fila d'articles
                foreach ($files as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['titol'] . "</td>";
                    echo "<td>" . $row['cos'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <br>
    <!-- Enllaç per tornar enrere -->
    <a href="../controlador/logout.php">Tornar</a>
</body>

</html>