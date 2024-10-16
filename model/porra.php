<?php
// Alexis Boisset

/* Funció que serveix per a omplenar les diferències que hi ha entre les ID d'una fila a una altra. */
function ultimaIdDisponible($conn)
{
    $contador = 1;

    $query = "SELECT id FROM usuaris";
    $allId = $conn->prepare($query);
    // No es pot fer un execute() directament sense un prepare(), sembla un Diesel que tens que deixar que escalfi tu. 

    $allId->execute();

    $idDisponible = $allId->fetchAll(PDO::FETCH_COLUMN, 0);

    foreach ($idDisponible as $idActual) {
        if ($contador != $idActual) {
            return $contador;
        }
        $contador++;
    }

    return $contador;
}

// Select de tota la vida

/* function consultarArticle($conn, $id)
{
    $sql = "SELECT e1.nombre AS equipo_local, e2.nombre AS equipo_visitante, p.goles_local, p.goles_visitante, p.fecha
            FROM partidos p
            JOIN equipos e1 ON p.equipo_local_id = e1.id
            JOIN equipos e2 ON p.equipo_visitante_id = e2.id
            WHERE p.jugado = 1;";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt;
} */

/* function insert($conn, $nombre, $descripcion)
{
    $sql = "INSERT INTO articles (id, titol, cos) VALUES (:id, :nombre, :descripcion)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', ultimaIdDisponible($conn));
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);

    return $stmt;
} */

function insertPartido($conn, $equipo_local, $equipo_visitante, $fecha, $goles_local, $goles_visitante) {
    $jugado = (!is_null($goles_local) && !is_null($goles_visitante)) ? 1 : 0;
    $sql = "INSERT INTO partits (equipo_local_id, equipo_visitante_id, fecha, goles_local, goles_visitante, jugado) 
            VALUES (:equipo_local, :equipo_visitante, :fecha, :goles_local, :goles_visitante, :jugado)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':equipo_local', $equipo_local);
    $stmt->bindParam(':equipo_visitante', $equipo_visitante);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':goles_local', $goles_local);
    $stmt->bindParam(':goles_visitante', $goles_visitante);
    $stmt->bindParam(':jugado', $jugado);

    return $stmt;
}

function updatePartido($conn, $id, $equipo_local, $equipo_visitante, $fecha, $goles_local, $goles_visitante) {
    $jugado = (!is_null($goles_local) && !is_null($goles_visitante)) ? 1 : 0;
    $sql = "UPDATE partits 
            SET equipo_local_id = :equipo_local, equipo_visitante_id = :equipo_visitante, fecha = :fecha, 
                goles_local = :goles_local, goles_visitante = :goles_visitante, jugado = :jugado 
            WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':equipo_local', $equipo_local);
    $stmt->bindParam(':equipo_visitante', $equipo_visitante);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':goles_local', $goles_local);
    $stmt->bindParam(':goles_visitante', $goles_visitante);
    $stmt->bindParam(':jugado', $jugado);

    return $stmt;
}

function consultarPartido($conn, $id) {
    $sql = "SELECT * FROM partits WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt;
}


/* function update($conn, $id, $nombre, $descripcion)
{
    $sql = "UPDATE articles SET titol = :nombre, cos = :descripcion WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);

    return $stmt;
}

function delete($conn, $id)
{
    $sql = "DELETE FROM articles WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindparam(':id', $id);

    return $stmt;
}

function allArticles($conn)
{
    $sql = "SELECT * FROM articles";
    $resultat = $conn->prepare($sql);

    $resultat->execute();

    $resultat = $resultat->fetchAll(PDO::FETCH_ASSOC);

    return $resultat;
}
 */
