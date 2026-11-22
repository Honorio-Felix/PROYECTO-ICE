
<?php

require_once __DIR__ . '/../../config/Conexion.php';

class Programa {

    private $conexion;

    public function __construct() {
        $database = new Conexion();
        $this->conexion = $database->conectar();
    }

    // 1. LISTAR PROGRAMAS
    public function listar() {

        $sql = "SELECT
                    p.*,
                    c.nombre AS categoria,
                    m.nombre AS modalidad,
                    CONCAT(d.nombres, ' ', d.apellidos) AS docente
                FROM programas p
                INNER JOIN categorias c
                    ON p.id_categoria = c.id_categoria
                INNER JOIN modalidades m
                    ON p.id_modalidad = m.id_modalidad
                INNER JOIN docentes d
                    ON p.id_docente = d.id_docente
                ORDER BY p.id_programa";

        $consulta = $this->conexion->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. BUSCAR PROGRAMA POR ID
    public function buscarPorId($id) {

        $sql = "SELECT
                    p.*,
                    c.nombre AS categoria,
                    m.nombre AS modalidad,
                    CONCAT(d.nombres, ' ', d.apellidos) AS docente
                FROM programas p
                INNER JOIN categorias c
                    ON p.id_categoria = c.id_categoria
                INNER JOIN modalidades m
                    ON p.id_modalidad = m.id_modalidad
                INNER JOIN docentes d
                    ON p.id_docente = d.id_docente
                WHERE p.id_programa = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);

        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    // 3. CREAR PROGRAMA
    public function crear($datos) {

        $sql = "INSERT INTO programas (
                    id_categoria,
                    id_modalidad,
                    id_docente,
                    nombre,
                    descripcion,
                    duracion_horas,
                    fecha_inicio,
                    brochure
                ) VALUES (
                    :id_categoria,
                    :id_modalidad,
                    :id_docente,
                    :nombre,
                    :descripcion,
                    :duracion_horas,
                    :fecha_inicio,
                    :brochure
                )";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute([
            ':id_categoria' => $datos['id_categoria'],
            ':id_modalidad' => $datos['id_modalidad'],
            ':id_docente' => $datos['id_docente'],
            ':nombre' => $datos['nombre'],
            ':descripcion' => $datos['descripcion'],
            ':duracion_horas' => $datos['duracion_horas'],
            ':fecha_inicio' => $datos['fecha_inicio'],
            ':brochure' => $datos['brochure']
        ]);

        return $this->conexion->lastInsertId();
    }

    // 4. ACTUALIZAR PROGRAMA
    public function actualizar($id, $datos) {

        $sql = "UPDATE programas SET
                    id_categoria = :id_categoria,
                    id_modalidad = :id_modalidad,
                    id_docente = :id_docente,
                    nombre = :nombre,
                    descripcion = :descripcion,
                    duracion_horas = :duracion_horas,
                    fecha_inicio = :fecha_inicio,
                    brochure = :brochure
                WHERE id_programa = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->execute([
            ':id_categoria' => $datos['id_categoria'],
            ':id_modalidad' => $datos['id_modalidad'],
            ':id_docente' => $datos['id_docente'],
            ':nombre' => $datos['nombre'],
            ':descripcion' => $datos['descripcion'],
            ':duracion_horas' => $datos['duracion_horas'],
            ':fecha_inicio' => $datos['fecha_inicio'],
            ':brochure' => $datos['brochure'],
            ':id' => $id
        ]);

        return $consulta->rowCount();
    }

    // 5. ELIMINAR PROGRAMA
    public function eliminar($id) {

        $sql = "DELETE FROM programas
                WHERE id_programa = :id";

        $consulta = $this->conexion->prepare($sql);

        $consulta->bindValue(':id', $id, PDO::PARAM_INT);

        $consulta->execute();

        return $consulta->rowCount();
    }
}
