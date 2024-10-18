<?php
// Alexis Boisset



function insertPartido($conn, $equipo_local_id, $equipo_visitante_id, $fecha, $goles_local, $goles_visitante)
{
    $jugado = (!is_null($goles_local) && !is_null($goles_visitante)) ? 1 : 0;
    $sql = "INSERT INTO partits (equip_local_id, equip_visitant_id, data, gols_local, gols_visitant, jugat) 
            VALUES (:equipo_local_id, :equipo_visitante_id, :fecha, :goles_local, :goles_visitante, :jugado)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':equipo_local_id', $equipo_local_id);
    $stmt->bindParam(':equipo_visitante_id', $equipo_visitante_id);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':goles_local', $goles_local);
    $stmt->bindParam(':goles_visitante', $goles_visitante);
    $stmt->bindParam(':jugado', $jugado);

    return $stmt; // Retorna el statement per executar-lo després
}

function updatePartido($conn, $id, $equipo_local_id, $equipo_visitante_id, $fecha, $goles_local, $goles_visitante)
{
    $jugado = (!is_null($goles_local) && !is_null($goles_visitante)) ? 1 : 0;
    $sql = "UPDATE partits 
            SET equip_local_id = :equipo_local_id, equip_visitant_id = :equipo_visitante_id, data = :fecha, 
                gols_local = :goles_local, gols_visitant = :goles_visitante, jugat = :jugado 
            WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':equipo_local_id', $equipo_local_id);
    $stmt->bindParam(':equipo_visitante_id', $equipo_visitante_id);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':goles_local', $goles_local);
    $stmt->bindParam(':goles_visitante', $goles_visitante);
    $stmt->bindParam(':jugado', $jugado);

    return $stmt; // Retorna el statement per executar-lo després
}

// Creo un optional parameter per si utilitzo la funció sense passar un valor d'ID, serveix per reutilitzar la funció en controlador/list.php
function consultarPartido($conn, $id = '')
{
    if (empty($id)) {
        $sql = "SELECT * FROM partits";
        $stmt = $conn->prepare($sql);
    } else {
        $sql = "SELECT * FROM partits WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
    }

    return $stmt->execute(); // Retorna el statement per a futures manipulacions
}

function getTeamName($conn, $id)
{
    $stmt = $conn->prepare("SELECT nom FROM equips WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getTeamID($conn, $nom)
{
    $stmt = $conn->prepare("SELECT id FROM equips WHERE nom = :nom");
    $stmt->bindParam(':nom', $nom);
    $stmt->execute();
    return $stmt->fetchColumn();
}


/* 
function update($conn, $id, $nombre, $descripcion) {
    $sql = "UPDATE articles SET titol = :nombre, cos = :descripcion WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);

    return $stmt; // Retorna el statement per a futures manipulacions
}

function delete($conn, $id) {
    $sql = "DELETE FROM articles WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id); // Correcció de la funció: 'bindparam' a 'bindParam'

    return $stmt; // Retorna el statement per a futures manipulacions
}

function allArticles($conn) {
    $sql = "SELECT * FROM articles";
    $resultat = $conn->prepare($sql);
    $resultat->execute();

    return $resultat->fetchAll(PDO::FETCH_ASSOC); // Retorna tots els articles com un array associatiu
}
*/
