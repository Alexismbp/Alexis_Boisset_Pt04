<?php
session_start();
require "../controlador/config.php"; // Detecció de temps d'inactivitat
?>
<!-- Alexis Boisset -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/styles.css"> <!-- La teva fulla d'estils -->
</head>

<body>
    <div class="container mt-5 d-flex justify-content-center align-items-center">
        <div>
            <h1>Eliminar element</h1>

            <!-- Missatges de feedback -->
            <?php if ($_GET["error"] == 2) { ?>
                <div class="alert alert-danger noole">La ID ha de ser numèrica i no pot estar buida, home que ja tenim una edat.</div>
            <?php } elseif (isset($_GET["failure"])) { ?>
                <div class="alert alert-danger noole">Algo no ha funcionat com hauria :(</div>
            <?php } elseif (isset($_GET["success"])) { ?>
                <div class="alert alert-success ole">¡Article esborrat correctament!</div>
            <?php } ?>

            <!-- Formulari -->
            <form id="deleteForm" action="../controlador/delete.php" method="post">
                <label for="id">ID de l'element a eliminar (numèrica):</label>
                <input type="text" class="form-control" id="id" name="id">

                <div class="d-grid gap-2 mt-4">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                        Eliminar
                    </button>
                </div>
            </form>

            <!-- Modal de confirmació -->
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminació</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Estás seguro de que quieres eliminar este artículo?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <!-- Enllaç per tornar enrere -->
            <a href="../index.php" class="btn btn-secondary">Tornar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Al fer clic a "Eliminar" dins del modal
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            // Envia el formulari al confirmar
            document.getElementById('deleteForm').submit();
        });
    </script>
</body>

</html>