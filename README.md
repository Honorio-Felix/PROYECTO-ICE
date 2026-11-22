
# API REST MVC – Instituto de Comercio Exterior (ICE)

## 1. Descripción del proyecto

API REST para administrar información académica y comercial del Instituto de Comercio Exterior (ICE). Desarrollada en PHP con arquitectura MVC, conexión PDO y base de datos MySQL.

Permite gestionar ocho módulos mediante operaciones CRUD: categorías, modalidades, docentes, programas, módulos de programa, prospectos, solicitudes y matrículas.

## 2. Tecnologías utilizadas

- PHP 8.2
- MySQL / MariaDB y PDO
- Apache y XAMPP
- Postman
- Node.js, npm y Tailwind CSS
- Git y GitHub

## 3. Arquitectura MVC

- **Modelos:** `app/Models/`. Gestionan las consultas a la base de datos.
- **Controladores:** `app/Controllers/`. Procesan las solicitudes y coordinan las operaciones.
- **Rutas:** `routers/`. Dirigen las peticiones HTTP al controlador correspondiente.
- **Configuración:** `config/`. Contiene la conexión PDO.

## 4. Estructura del proyecto

```text
PROYECTO-ICE/
├── app/
│   ├── Controllers/
│   └── Models/
├── config/
├── core/
├── dist/
├── public/
├── routers/
├── src/
├── .env.example
├── .gitignore
├── BD.sql
├── package.json
├── tailwind.config.js
└── README.md
```

## 5. Módulos de la API

| Módulo | Tabla |
|---|---|
| Categorías | `categorias` |
| Modalidades | `modalidades` |
| Docentes | `docentes` |
| Programas | `programas` |
| Módulos de Programa | `modulos_programa` |
| Prospectos | `prospectos` |
| Solicitudes | `solicitudes` |
| Matrículas | `matriculas` |

## 6. Base de datos

- **Nombre:** `ice_comercio_exterior`
- **Archivo:** `BD.sql`

El script contiene la creación de la base de datos, sus ocho tablas, relaciones y datos iniciales.

Para importarlo, inicia Apache y MySQL en XAMPP, abre phpMyAdmin, selecciona **Importar** y carga `BD.sql`.

## 7. Instalación y configuración

1. Coloca la carpeta `PROYECTO-ICE` en `C:\xampp\htdocs\`.
2. Inicia Apache y MySQL desde XAMPP.
3. Crea un archivo `.env` en la raíz, tomando como referencia `.env.example`.
4. Configura las credenciales de tu entorno local:

```ini
DB_HOST=localhost
DB_NAME=ice_comercio_exterior
DB_USER=root
DB_PASS=
```

5. Importa `BD.sql` desde phpMyAdmin.

**Inicio de la API:**

```text
http://localhost/PROYECTO-ICE/public/
```

**Dirección base de las rutas:**

```text
http://localhost/PROYECTO-ICE/routers/
```

No publiques el archivo `.env`; contiene configuración privada y está excluido mediante `.gitignore`.

## 8. Endpoints de la API

| Módulo | Archivo de ruta |
|---|---|
| Categorías | `categorias.php` |
| Modalidades | `modalidades.php` |
| Docentes | `docentes.php` |
| Programas | `programas.php` |
| Módulos de Programa | `modulos_programa.php` |
| Prospectos | `prospectos.php` |
| Solicitudes | `solicitudes.php` |
| Matrículas | `matriculas.php` |

Los módulos implementan las operaciones CRUD mediante estos métodos:

| Método HTTP | Operación |
|---|---|
| GET | Listar o consultar por ID |
| POST | Crear |
| PUT | Actualizar |
| DELETE | Eliminar |

**Ejemplo – listar categorías:**

```http
GET http://localhost/PROYECTO-ICE/routers/categorias.php
```

## 9. Validaciones y respuestas HTTP

La API responde en formato JSON y utiliza códigos HTTP, entre ellos:

| Código | Significado |
|---|---|
| 200 | Operación exitosa |
| 201 | Registro creado |
| 400 | Datos inválidos o error de integridad |
| 404 | Registro no encontrado |
| 405 | Método no permitido |
| 500 | Error interno del servidor |

## 10. Seguridad e integridad de datos

- Conexión mediante PDO y consultas preparadas.
- Validación de los datos recibidos.
- Manejo de excepciones.
- Restricciones de integridad referencial.
- Credenciales mediante variables de entorno.
- Exclusión del archivo `.env` en Git.

## 11. Pruebas

Los endpoints fueron probados mediante Postman para los ocho módulos y sus operaciones CRUD.

**Resultado de la ejecución final de la colección:** 167 pruebas aprobadas, 0 fallidas y 0 errores. Las capturas de evidencia se incluyen en el archivo ZIP de evidencias de la entrega.

## 12. Entrega del proyecto

La entrega contempla:

- Código fuente publicado en GitHub.
- Base de datos (`BD.sql`).
- Documentación (`README.md`).
- Archivo de ejemplo de configuración (`.env.example`).
- ZIP con las capturas de evidencias.

**Repositorio:** https://github.com/Honorio-Felix/PROYECTO-ICE

**Proyecto académico:** API REST MVC – Instituto de Comercio Exterior (ICE).
