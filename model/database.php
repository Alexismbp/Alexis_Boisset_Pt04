<?php
// Alexis Boisset

class Database
{

    private $servername = "127.0.0.1";  // Host del servidor MySQL
    private $dbname = "Pt02_Alexis_Boisset";  // Nom de la base de dades
    private $username = "root";  // Nom d'usuari MySQL
    private $password = "";  // Contrasenya MySQL


    // DSN correctament formatat
    public function connect()
    {
        // Convertir el nombre de la base de datos a minúsculas para evitar problemas
        $dbname = strtolower($this->dbname);

        // Generar el DSN con el nombre de la base de datos en minúsculas
        $dsn = "mysql:host=" . $this->servername . ";dbname=" . $dbname;

        try {
            // Creem una nova connexió PDO
            $conn = new PDO($dsn, $this->username, $this->password);

            // Configurem PDO perquè llanci excepcions en cas d'error
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;
        } catch (PDOException $e) {
            die("Error de connexió: " . $e->getMessage());
            
            return null;
        }
    }


    /*Funció que serveix per a omplenar les diferencies que hi ha entre les ID d'una row a un altra. */
    private function ultimaIdDisponible($conn)
    {
        $contador = 1;
        $IdFound = false;
        $query = "SELECT id FROM articles";
        $allId = $conn->prepare($query);
        //No es pot fer un execute() directament sense un prepare(), sembla un Diesel que tens que deixar que escalfi tu. 

        $allId->execute();

        $idDisponible = $allId->fetchAll(PDO::FETCH_COLUMN, 0);

        foreach ($idDisponible as $idActual) {
            if ($contador != $idActual) {
                $IdFound = true;
                return $contador;
            }
            $contador++;
        }

        return $contador;
    }


    //Select de tota la vida

    public function consultarArticle($conn, $id)
    {
        $sql = "SELECT titol, cos FROM articles WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    public function insert($conn, $nombre, $descripcion)
    {

        $sql = "INSERT INTO articles (id, titol, cos) VALUES (:id, :nombre, :descripcion)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $this->ultimaIdDisponible($conn));
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);

        return $stmt;
    }

    public function update($conn, $id, $nombre, $descripcion)
    {
        $sql = "UPDATE articles SET titol = :nombre, cos = :descripcion WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);

        return $stmt;
    }

    public function delete($conn, $id)
    {
        $sql = "DELETE FROM articles WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindparam(':id', $id);

        return $stmt;
    }

    public function allArticles($conn)
    {
        $sql = "SELECT * FROM articles";
        $resultat = $conn->prepare($sql);

        $resultat->execute();

        $resultat = $resultat->fetchAll(PDO::FETCH_ASSOC);

        return $resultat;
    }
}
