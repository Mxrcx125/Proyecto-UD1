# Práctica UD1: Entorno de desarrollo con Docker (Nginx, PHP 8.3 y MySQL)

Proyecto de despliegue de un entorno LEMP modular utilizando Docker y Docker Compose, sustituyendo la instalación local tradicional de paquetes tipo XAMPP por contenedores independientes y aislados.

## Servicios

El entorno está compuesto por tres contenedores interconectados mediante `docker-compose.yml`:

- **web (Nginx)**: Servidor web que escucha en el puerto host 8080 y redirige las peticiones al contenedor de PHP mediante FastCGI.
- **php (PHP-FPM 8.3)**: Intérprete de PHP construido a partir de `php/Dockerfile`, con la extensión `pdo_mysql` instalada.
- **db (MySQL 8.0)**: Base de datos MySQL con almacenamiento persistente mediante volumen Docker.

## Estructura del repositorio

- `docker-compose.yml`: Definición, variables y conexión de los tres servicios.
- `nginx/default.conf`: Configuración de Nginx y comunicación con PHP-FPM.
- `php/Dockerfile`: Construcción de la imagen PHP 8.3 con soporte PDO.
- `src/index.php`: Script de prueba que comprueba la versión de PHP y realiza lectura y escritura en MySQL vía PDO.
- `Captura.png`: Captura de pantalla del resultado.

## Instrucciones de uso

### 1. Iniciar los contenedores
Para construir e iniciar los servicios en segundo plano:

```bash
docker compose up -d
```

### 2. Comprobar el funcionamiento
Abrir en el navegador:

http://localhost:8080

### 3. Detener los contenedores
Para parar los servicios:

```bash
docker compose down
```

## Resultado

Captura de pantalla de la comprobación del entorno en funcionamiento:

![Resultado](Captura.png)
