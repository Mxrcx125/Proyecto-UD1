# Práctica UD1: Servidor con Docker

En este proyecto he montado un servidor con Nginx, PHP 8.3 y MySQL usando Docker Compose en lugar de XAMPP. Cada servicio va en su propio contenedor: Nginx recibe las peticiones en el puerto 8080 y se las pasa a PHP, y desde PHP nos conectamos a la base de datos MySQL mediante PDO.

## Cómo levantarlo

Para arrancar los tres contenedores solo tenemos que ejecutar en la terminal `docker compose up -d`. Una vez iniciado, entramos desde el navegador en http://localhost:8080 para ver que todo funciona correctamente.

## Resultado

![Captura del resultado](Captura.png)
