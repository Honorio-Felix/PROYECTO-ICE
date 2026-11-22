
<?php

require_once __DIR__ . '/../../config/Conexion.php';

class Categoria {

    private $conexion;
    private $tabla = "categorias";

    public function __construct() {

        $database = new Conexion();

        $this->conexion = $database->conectar();
    }

    // 1. LISTAR TODAS LAS CATEGORIAS
    public function listar() {

        $sql = "SELECT * FROM " . $this->tabla .
               " ORDER BY id_categoria ASC";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute();

        return $consulta->fetchAll();
    }

    // 2. BUSCAR UNA CATEGORIA POR SU ID
    public function buscarPorId($id) {

        $sql = "SELECT * FROM " . $this->tabla .
               " WHERE id_categoria = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->bindParam(':id', $id, PDO::PARAM_INT);

        $consulta->execute();

        return $consulta->fetch();
    }

    // 3. CREAR UNA NUEVA CATEGORIA
    public function crear($nombre, $descripcion) {

        $sql = "INSERT INTO " . $this->tabla .
               " (nombre, descripcion)
               VALUES (:nombre, :descripcion)";

        $consulta = $this->conexion->prepare($sql);

        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':descripcion', $descripcion);

        $consulta->execute();

        return $this->conexion->lastInsertId();
    }

    // 4. ACTUALIZAR UNA CATEGORIA
    public function actualizar($id, $nombre, $descripcion) {

        $sql = "UPDATE " . $this->tabla .
               " SET nombre = :nombre,
                     descripcion = :descripcion
                 WHERE id_categoria = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':descripcion', $descripcion);

        $consulta->execute();

        return $consulta->rowCount();
    }

    // 5. ELIMINAR UNA CATEGORIA
    public function eliminar($id) {

        $sql = "DELETE FROM " . $this->tabla .
               " WHERE id_categoria = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->bindParam(':id', $id, PDO::PARAM_INT);

        $consulta->execute();

        return $consulta->rowCount();
    }

}
