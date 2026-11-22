
<?php

require_once __DIR__ . '/../../config/Conexion.php';

class Modalidad {

    private $conexion;

    public function __construct() {

        $database = new Conexion();

        $this->conexion = $database->conectar();
    }

    // 1. LISTAR MODALIDADES
    public function listar() {

        $sql = "SELECT * FROM modalidades ORDER BY id_modalidad ASC";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute();

        return $consulta->fetchAll();
    }

    // 2. BUSCAR MODALIDAD POR ID
    public function buscarPorId($id) {

        $sql = "SELECT * FROM modalidades WHERE id_modalidad = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->bindParam(':id', $id, PDO::PARAM_INT);

        $consulta->execute();

        return $consulta->fetch();
    }

    // 3. REGISTRAR MODALIDAD
    public function registrar($nombre, $descripcion) {

        $sql = "INSERT INTO modalidades (nombre, descripcion)
                VALUES (:nombre, :descripcion)";

        $consulta = $this->conexion->prepare($sql);

        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':descripcion', $descripcion);

        $consulta->execute();

        // Devolver el ID autogenerado para que el controlador lo envíe en JSON
        return $this->conexion->lastInsertId();
    }

    // 4. ACTUALIZAR MODALIDAD
    public function actualizar($id, $nombre, $descripcion) {

        $sql = "UPDATE modalidades
                SET nombre = :nombre, descripcion = :descripcion
                WHERE id_modalidad = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':descripcion', $descripcion);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);

        return $consulta->execute();
    }

    // 5. ELIMINAR MODALIDAD
    public function eliminar($id) {

        $sql = "DELETE FROM modalidades WHERE id_modalidad = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->bindParam(':id', $id, PDO::PARAM_INT);

        return $consulta->execute();
    }
}
