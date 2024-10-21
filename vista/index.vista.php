<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de partits</title>
    <link rel="stylesheet" href="./vista/styles/styles.css">
</head>

<header>
    <?php if (!isset($_SESSION['loggedin'])): ?>
        <!-- Opciones de logarse o registrar-se cuando no está logado -->
        <a href="./vista/login.vista.php" class="btn-login">Logar-se</a>
        <a href="./vista/register.view.php" class="btn-register">Enregistrar-se</a>
    <?php else: ?>
        <!-- Mensaje cuando el usuario ya está logado -->
        <p>Benvingut, <?php echo $_SESSION['username']; ?>!</p>
        <a href="./controlador/logout.php" class="btn-logout">Tancar sessió</a>
    <?php endif; ?>
</header>

<body>
    <h1>Partits de LaLliga</h1>
    <?php if ($_SESSION['loggedin']) : ?>
        <ul>
            <!-- Enllaços per a gestionar els partits -->
            <li><a href="vista/crear_partit.php">Crear nou partit</a></li>
        </ul>
    <?php endif ?>

    <!-- Select per a triar quants partits mostrar per pàgina -->
    <form method="GET" action="index.php" class="form-partits-per-page">
        <label for="partitsPerPage">Partits per pàgina:</label>
        <select id="partitsPerPage" name="partitsPerPage" onchange="this.form.submit()">
            <option value="5" <?php if ($partitsPerPage == 5) echo 'selected'; ?>>5</option>
            <option value="10" <?php if ($partitsPerPage == 10) echo 'selected'; ?>>10</option>
            <option value="15" <?php if ($partitsPerPage == 15) echo 'selected'; ?>>15</option>
            <option value="20" <?php if ($partitsPerPage == 20) echo 'selected'; ?>>20</option>
        </select>
    </form>

    <!-- Mostra els partits paginats -->
    <h2>Llista de partits</h2>
    <?php if (count($partits) > 0): ?>
        <div class="partits">
            <?php foreach ($partits as $partit): ?>
                <div class="partit">
                    <h3><?php echo htmlspecialchars($partit['equip_local']) . " vs " . htmlspecialchars($partit['equip_visitant']); ?></h3>

                    <?php if ($partit['jugat']): ?>
                        <!-- Si el partit ja s'ha jugat, mostrar el resultat -->
                        <p>Resultat: <?php echo $partit['gols_local'] . " - " . $partit['gols_visitant']; ?></p>
                    <?php else: ?>
                        <!-- Si el partit encara no s'ha jugat, mostrar la data programada -->
                        <p>Partit programat per al: <?php echo date('d-m-Y', strtotime($partit['data'])); ?></p>
                    <?php endif; ?>

                    <?php if ($_SESSION['loggedin']): ?>
                        <a href="vista/crear_partit.php?id=<?php echo $partit['id']?>">Editar Partit</a>
                        <a href="vista/eliminar.php?id=<?php echo $partit['id']?>">Eliminar Partit</a>
                    <?php endif ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Navegació de paginació -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>&partitsPerPage=<?= $partitsPerPage ?>">Anterior</a>
            <?php endif; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>&partitsPerPage=<?= $partitsPerPage ?>">Següent</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p class="partit">No hi ha partits disponibles.</p>
    <?php endif; ?>
</body>

</html>
