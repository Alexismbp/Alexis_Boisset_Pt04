<?php
// Alexis Boisset

    /*Funció que serveix per a omplenar les diferencies que hi ha entre les ID d'una row a un altra. */
    function ultimaIdDisponible($conn)
    {
        $contador = 1;
        
        $query = "SELECT id FROM articles";
        $allId = $conn->prepare($query);
        //No es pot fer un execute() directament sense un prepare(), sembla un Diesel que tens que deixar que escalfi tu. 

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


    //Select de tota la vida

    function consultarArticle($conn, $id)
    {
        $sql = "SELECT titol, cos FROM articles WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    function insert($conn, $nombre, $descripcion)
    {

        $sql = "INSERT INTO articles (id, titol, cos) VALUES (:id, :nombre, :descripcion)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', ultimaIdDisponible($conn));
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);

        return $stmt;
    }

    function update($conn, $id, $nombre, $descripcion)
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

