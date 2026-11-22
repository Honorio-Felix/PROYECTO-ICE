# API REST MVC – Instituto de Comercio Exterior (ICE)

## 1. Descripción del proyecto

El proyecto ICE consiste en el desarrollo de una API REST para administrar la información académica y comercial del Instituto de Comercio Exterior.

La aplicación está desarrollada con PHP y utiliza una arquitectura MVC (Modelo-Vista-Controlador), conectada a una base de datos MySQL mediante PDO.

Su finalidad es permitir la gestión de categorías, modalidades, docentes, programas de formación, módulos, prospectos, solicitudes y matrículas mediante operaciones CRUD.

## 2. Tecnologías utilizadas

- **PHP 8.2:** desarrollo de la lógica del servidor.
- **MySQL / MariaDB:** gestión de la base de datos.
- **PDO:** conexión y ejecución de consultas preparadas.
- **Apache:** servidor web proporcionado por XAMPP.
- **XAMPP:** entorno de desarrollo local.
- **Postman:** herramienta para probar los endpoints.
- **Node.js y npm:** gestión y compilación de recursos de Tailwind CSS.
- **Git y GitHub:** control de versiones y publicación del código fuente.

## 3. Arquitectura MVC

El proyecto utiliza una arquitectura basada en tres componentes principales:

### Modelos (Models)

Ubicados en `app/Models/`.

Se encargan de interactuar con la base de datos mediante consultas SQL. Contienen las operaciones para listar, consultar, crear, actualizar y eliminar registros.

### Controladores (Controllers)

Ubicados en `app/Controllers/`.

Reciben las solicitudes de los routers, validan los datos enviados, ejecutan las operaciones del modelo y generan respuestas en formato JSON.

### Rutas (Routers)

Ubicadas en `routers/`.

Reciben las peticiones HTTP y las derivan al controlador correspondiente según el método solicitado.

### Configuración

Ubicada en `config/`.

Contiene la configuración de conexión a MySQL mediante PDO.

## 4. Estructura del proyecto

```text
PROYECTO-ICE/
│
├── app/
│   ├── Controllers/
│   │   ├── CategoriaController.php
│   │   ├── ModalidadController.php
│   │   ├── DocenteController.php
│   │   ├── ProgramaController.php
│   │   ├── ModuloProgramaController.php
│   │   ├── ProspectoController.php
│   │   ├── SolicitudController.php
│   │   └── MatriculaController.php
│   │
│   └── Models/
│       ├── Categoria.php
│       ├── Modalidad.php
│       ├── Docente.php
│       ├── Programa.php
│       ├── ModuloPrograma.php
│       ├── Prospecto.php
│       ├── Solicitud.php
│       └── Matricula.php
│
├── config/
│   └── Conexion.php
│
├── core/
│
├── dist/
│
├── public/
│   └── index.php
│
├── routers/
│   ├── categorias.php
│   ├── modalidades.php
│   ├── docentes.php
│   ├── programas.php
│   ├── modulos_programa.php
│   ├── prospectos.php
│   ├── solicitudes.php
│   └── matriculas.php
│
├── src/
│
├── .env
├── .env.example
├── .gitignore
├── BD.sql
├── package.json
├── package-lock.json
├── tailwind.config.js
└── README.md
```

**Nota:** La estructura muestra las carpetas principales y los archivos relevantes para la API. Las carpetas de recursos del proyecto pueden contener archivos adicionales.

## 5. Módulos de la API

La API cuenta con ocho módulos principales:

| N.º | Módulo | Tabla |
|---|---|---|
| 1 | Categorías | categorias |
| 2 | Modalidades | modalidades |
| 3 | Docentes | docentes |
| 4 | Programas | programas |
| 5 | Módulos de Programa | modulos_programa |
| 6 | Prospectos | prospectos |
| 7 | Solicitudes | solicitudes |
| 8 | Matrículas | matriculas |

Cada módulo implementa las operaciones CRUD correspondientes para administrar sus registros.

## 6. Base de datos

**Nombre de la base de datos:** `ice_comercio_exterior`

El archivo `BD.sql` contiene la estructura de la base de datos y los datos de prueba.

Para importar la base de datos:

1. Iniciar Apache y MySQL desde XAMPP.
2. Ingresar a phpMyAdmin.
3. Seleccionar la opción **Importar**.
4. Elegir el archivo `BD.sql`.
5. Ejecutar la importación.
6. Verificar que se haya creado `ice_comercio_exterior` con sus ocho tablas y datos de prueba.

La base de datos contiene ocho tablas principales y sus relaciones mediante claves foráneas.

## 7. Configuración del proyecto

### Requisitos

- XAMPP instalado.
- Apache y MySQL habilitados.
- PHP 8.2 o una versión compatible.
- Navegador web.
- Postman para realizar las pruebas de los endpoints.

### Paso 1. Ubicar el proyecto

Colocar la carpeta dentro de:

```text
C:\xampp\htdocs\PROYECTO-ICE
```

### Paso 2. Configurar las variables de entorno

El proyecto utiliza un archivo `.env` para almacenar los datos de conexión.

Se proporciona `.env.example` como plantilla de configuración.

Crear el archivo `.env` en la raíz del proyecto con los valores correspondientes al entorno local:

```ini
DB_HOST=localhost
DB_NAME=ice_comercio_exterior
DB_USER=root
DB_PASS=
```

No publicar el archivo `.env` en GitHub, ya que contiene información de configuración privada.

### Paso 3. Preparar la base de datos

1. Abrir phpMyAdmin.
2. Importar el archivo `BD.sql`.
3. Verificar que se haya creado la base de datos `ice_comercio_exterior`.

### Paso 4. Ejecutar el proyecto

Iniciar Apache y MySQL desde el panel de XAMPP.

**Página de inicio de la API:**

```text
http://localhost/PROYECTO-ICE/public/
```

**Dirección base de los endpoints:**

```text
http://localhost/PROYECTO-ICE/routers/
```

## 8. Endpoints de la API

| Módulo | Endpoint |
|---|---|
| Categorías | categorias.php |
| Modalidades | modalidades.php |
| Docentes | docentes.php |
| Programas | programas.php |
| Módulos de Programa | modulos_programa.php |
| Prospectos | prospectos.php |
| Solicitudes | solicitudes.php |
| Matrículas | matriculas.php |

### Métodos HTTP

| Método | Operación | Descripción |
|---|---|---|
| GET | Listar | Obtiene todos los registros. |
| GET por ID | Consultar | Busca un registro específico. |
| POST | Crear | Registra un nuevo elemento. |
| PUT | Actualizar | Modifica un registro existente. |
| DELETE | Eliminar | Elimina un registro. |

### Ejemplos de solicitudes

**Listar categorías:**

```http
GET http://localhost/PROYECTO-ICE/routers/categorias.php
```

**Buscar categoría por ID:**

```http
GET http://localhost/PROYECTO-ICE/routers/categorias.php?id=1
```

**Registrar una categoría:**

```http
POST http://localhost/PROYECTO-ICE/routers/categorias.php
Content-Type: application/json
```

Body:

```json
{
    "nombre": "Marketing Internacional",
    "descripcion": "Programas de marketing y negocios internacionales."
}
```

**Actualizar una categoría:**

```http
PUT http://localhost/PROYECTO-ICE/routers/categorias.php?id=1
Content-Type: application/json
```

**Eliminar una categoría:**

```http
DELETE http://localhost/PROYECTO-ICE/routers/categorias.php?id=1
```

## 9. Validaciones y respuestas HTTP

La API utiliza códigos de estado HTTP para comunicar el resultado de las operaciones:

| Código | Significado |
|---|---|
| 200 | Operación exitosa. |
| 201 | Registro creado correctamente. |
| 400 | Error de validación o integridad de datos. |
| 404 | Registro no encontrado. |
| 405 | Método HTTP no permitido. |
| 500 | Error interno del servidor. |

Las respuestas de la API se entregan en formato JSON.

Ejemplo:

```json
{
    "estado": true,
    "mensaje": "Docentes encontrados",
    "datos": []
}
```

## 10. Seguridad e integridad de datos

El proyecto contempla:

- Uso de PDO y consultas preparadas.
- Validación de datos recibidos.
- Control de identificadores.
- Manejo de excepciones.
- Restricciones de integridad referencial en MySQL.
- Uso de variables de entorno para las credenciales.
- Exclusión del archivo `.env` mediante `.gitignore`.

## 11. Pruebas

Los endpoints se verificarán mediante Postman.

Se realizarán pruebas para los ocho módulos, verificando:

- Listado de registros.
- Consulta por identificador.
- Creación de registros.
- Actualización de registros.
- Eliminación de registros.
- Validaciones y respuestas de error.

Las capturas de los resultados se incorporarán como evidencias de funcionamiento.

## 12. Entrega del proyecto

La entrega académica contempla:

- Código fuente del proyecto.
- Base de datos actualizada (`BD.sql`).
- Documentación (`README.md`).
- Archivo `.env.example`.
- Evidencias de pruebas realizadas en Postman.
- Repositorio de GitHub.

**Proyecto académico:** API REST MVC – Instituto de Comercio Exterior (ICE).