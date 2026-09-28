# Entorno de Desarrollo Docker LEMP (Nginx + PHP 8.3 + MySQL)

Este proyecto sustituye el modelo clásico monolítico (como XAMPP) por una arquitectura basada en contenedores Docker independientes, aislados y desechables para cada servicio.

---

## 🛠️ Arquitectura de Contenedores

Definidos y orquestados mediante un único `docker-compose.yml`:

| Contenedor | Servicio | Imagen / Build | Descripción |
| :--- | :--- | :--- | :--- |
| **`web`** | Nginx | `nginx:alpine` | Recibe peticiones HTTP en el puerto host `8080` y las reenvía a PHP vía FastCGI. |
| **`php`** | PHP-FPM | Dockerfile (`php:8.3-fpm-alpine`) | Ejecuta el código PHP 8.3 con soporte PDO para MySQL. |
| **`db`** | MySQL | `mysql:8.0` | Almacena los datos de la aplicación de forma persistente. |

---

## 📁 Estructura del Proyecto

```text
├── docker-compose.yml   # Definición y conexión de los tres servicios
├── nginx/
│   └── default.conf     # Configuración del virtualhost y proxy FastCGI
├── php/
│   └── Dockerfile       # Imagen PHP 8.3 con extensión pdo_mysql
├── src/
│   └── index.php        # Script de prueba (comprobación PHP 8.3 y conexión PDO)
├── .gitignore
└── README.md
```

---

## 🚀 Cómo levantar el entorno

### 1. Requisitos previos
- Tener instalado **Docker** y **Docker Compose** (por ejemplo, con Docker Desktop).

### 2. Iniciar los contenedores
Ejecuta el siguiente comando en la raíz del proyecto:

```bash
docker compose up -d --build
```

Esto descargará las imágenes, compilará el contenedor de PHP e iniciará los tres servicios en segundo plano.

### 3. Comprobar el funcionamiento
Abre tu navegador web y visita:

👉 **[http://localhost:8080](http://localhost:8080)**

Verás la interfaz con el estado en tiempo real de los tres servicios y una inserción/consulta de prueba en MySQL mediante PDO.

### 4. Detener el entorno
Para detener los contenedores:

```bash
docker compose down
```

Si además deseas eliminar los volúmenes de datos:

```bash
docker compose down -v
```

---

## 📸 Captura de Pantalla

A continuación se muestra la captura de pantalla del entorno funcionando en `http://localhost:8080`:

![Captura del resultado](Captura.png)
