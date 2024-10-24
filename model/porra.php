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
    $stmt->execute();
    return $stmt; // Retorna el statement per a futures manipulacions
}


function deletePartit($conn, $partit_id)
{
    $sql = "DELETE FROM partits WHERE id = :partit_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':partit_id', $partit_id, PDO::PARAM_INT);
    return $stmt->execute();
}

// Función para guardar la predicción en la base de datos
function guardarPrediccio($pdo, $partit_id, $usuari_id, $gols_local, $gols_visitant) {
    $stmt = $pdo->prepare("INSERT INTO prediccions (partit_id, usuari_id, gols_local, gols_visitant) VALUES (:partit_id, :usuari_id, :gols_local, :gols_visitant)");

    // Vincular parámetros
    $stmt->bindParam(':partit_id', $partit_id);
    $stmt->bindParam(':usuari_id', $usuari_id);
    $stmt->bindParam(':gols_local', $gols_local);
    $stmt->bindParam(':gols_visitant', $gols_visitant);

    // Ejecutar y devolver el resultado
    return $stmt->execute();
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
