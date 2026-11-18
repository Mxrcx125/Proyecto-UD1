# Desarrollo Web en Entorno Servidor (DWES)

[![PHP](https://img.shields.io/badge/PHP-8.3%20%7C%208.4-777bb4?logo=php&logoColor=white)](https://www.php.net/)
[![Docker](https://img.shields.io/badge/Docker-Compose-2496ed?logo=docker&logoColor=white)](https://www.docker.com/)
[![Nginx](https://img.shields.io/badge/Nginx-Alpine-009639?logo=nginx&logoColor=white)](https://nginx.org/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479a1?logo=mysql&logoColor=white)](https://www.mysql.com/)

Repositorio de prácticas y retos de la asignatura **Desarrollo Web en Entorno Servidor (DWES)** — 2.º DAW.

- **Alumno:** Marco García Ruiz
- **Curso:** 2.º DAW A (2026–2027)

---

## Tabla de Contenidos

1. [Estructura del Repositorio](#estructura-del-repositorio)
2. [UD01: Servidor con Docker](#ud01-servidor-con-docker)
3. [UD02: Reto «Forja de Héroes»](#ud02-reto-forja-de-héroes)
4. [Proyecto Integrado: «Gremio de Aventureros»](#proyecto-integrado-gremio-de-aventureros)
5. [Tabla de Rutas y Accesos](#tabla-de-rutas-y-accesos)
6. [Requisitos Previos](#requisitos-previos)

---

## Estructura del Repositorio

```text
Proyecto-UD1/
├── README.md                               <-- Portada principal del repositorio
├── .gitignore
│
├── UD01/                                   <-- Práctica 1: Servidor web Docker
│   ├── README.md                           <-- Documentación y captura de la UD01
│   ├── docker-compose.yml                  <-- Nginx + PHP 8.3 + MySQL 8.0
│   ├── Captura.png                         <-- Comprobación del servidor
│   ├── nginx/
│   │   └── default.conf
│   ├── php/
│   │   └── Dockerfile
│   └── src/
│       └── index.php
│
└── UD02/                                   <-- Práctica 2 y Retos integrados
    ├── entregas/                           <-- Archivos comprimidos de entrega (.zip)
    │   ├── forja_heroes_UD2.zip
    │   └── García_Ruiz_Marco_UD2.zip
    └── forja-heroes/                       <-- Entorno Docker (Nginx + PHP 8.4)
        ├── README.md                       <-- Guía de la UD02
        ├── MEMORIA.md                      <-- Memoria técnica y justificación
        ├── docker-compose.yml
        ├── capturas/                       <-- Capturas técnicas de comprobación
        ├── nginx/
        │   └── default.conf
        ├── php/
        │   └── forja.ini
        └── src/                            <-- Raíz web montada en /var/www/html
            ├── css/estilo.css
            ├── inc/heroe.php
            ├── ficha.php                   <-- Reto Forja de Héroes (Hechicero)
            ├── diagnostico.php             <-- Panel de diagnóstico PHP
            └── gremio/                     <-- Proyecto Gremio (UD3 · UD4 · UD5)
                ├── LEEME.md
                ├── MEMORIA.md
                ├── UD5_Gremio_Enunciado.docx
                ├── sql/gremio.sql          <-- Esquema y datos iniciales de MySQL
                └── src/                    <-- Código fuente del Gremio
                    ├── css/estilo.css
                    ├── inc/                <-- Conexión PDO, sesiones, helpers
                    ├── index.php           <-- Redirección al tablón
                    ├── tablon.php          <-- Tablón de misiones
                    ├── login.php           <-- Autenticación con password_verify
                    ├── logout.php          <-- Cierre de sesión
                    ├── zurron.php          <-- Gestión de misiones aceptadas
                    └── preferencias.php    <-- Configuración de usuario
```

---

## UD01: Servidor con Docker

Configuración y despliegue de una arquitectura contenerizada multi-servicio:

- **Nginx (Alpine):** Servidor HTTP inverso configurado para escuchar en el puerto `8080` y derivar peticiones PHP a FastCGI.
- **PHP 8.3 (FPM):** Contenedor compilado con la extensión oficial de **PDO MySQL** para persistencia relacional.
- **MySQL 8.0:** Motor de base de datos con volumen persistente (`db_data`).

### Despliegue:
```bash
cd UD01
docker compose up -d
```
Acceso desde el navegador: `http://localhost:8080`

---

## UD02: Reto «Forja de Héroes»

Reto de programación orientada a la lógica de servidor en PHP 8.4:

- **Variante asignada:** B · Hechicero (`Aldric <el Arcano>`).
- **Aspectos técnicos evaluados:**
  - Modo estricto activado mediante `declare(strict_types=1);`.
  - Operaciones aritméticas y redondeos precisos (vida máxima, daño, maná `pm`, poder total).
  - Sanitización de salidas en pantalla con `htmlspecialchars()` para prevenir ataques XSS.
  - Generación de barras visuales proporcionales en bloques Unicode (`█` y `░`).
  - Panel de control y diagnóstico de directivas de configuración PHP (`diagnostico.php`).

### Despliegue:
```bash
cd UD02/forja-heroes
docker compose up -d
```
- **Ficha del héroe:** `http://localhost:8080/ficha.php`
- **Panel de diagnóstico:** `http://localhost:8080/diagnostico.php`

---

## Proyecto Integrado: «Gremio de Aventureros»

Ubicado dentro del servidor web de la UD02 en `UD02/forja-heroes/src/gremio/`. Este proyecto abarca los conceptos de desarrollo avanzado en PHP:

1. **Gestión de Base de Datos (PDO):**
   - Conexión PDO segura con control de excepciones y juego de caracteres UTF-8.
   - Consultas preparadas (*prepared statements*) contra inyecciones SQL.
   - Script de base de datos ubicado en `UD02/forja-heroes/src/gremio/sql/gremio.sql`.
2. **Seguridad y Autenticación:**
   - Contraseñas almacenadas de forma unidireccional con algoritmo de hash seguro (`password_hash` / `password_verify`).
3. **Control de Sesiones y Estado:**
   - Control de sesiones PHP (`$_SESSION`) para usuarios autenticados y manejo de roles.
   - Tablón de misiones disponibles, filtrado por dificultad y aceptación hacia el zurrón.
   - Persistencia de preferencias de usuario.

### Usuarios de prueba:
| Usuario | Contraseña | Clase | Rol |
| :--- | :--- | :--- | :--- |
| `brunhilda` | `Martillo2026` | Guerrera | Aventurera |
| `aldric` | `Arcano2026` | Hechicero | Aventurero |
| `vex` | `Sombra2026` | Pícara | Aventurera |

### Acceso:
- **Tablón del Gremio:** `http://localhost:8080/gremio/src/`
- **Inicio de sesión:** `http://localhost:8080/gremio/src/login.php`

---

## Tabla de Rutas y Accesos

Con el contenedor de la UD02 activo (`docker compose up -d` en `UD02/forja-heroes`):

| Módulo | Ruta URL | Descripción |
| :--- | :--- | :--- |
| **Forja de Héroes** | [http://localhost:8080/ficha.php](http://localhost:8080/ficha.php) | Ficha de estadísticas del Hechicero |
| **Diagnóstico PHP** | [http://localhost:8080/diagnostico.php](http://localhost:8080/diagnostico.php) | Panel de configuración y extensiones PHP |
| **Gremio - Tablón** | [http://localhost:8080/gremio/src/](http://localhost:8080/gremio/src/) | Tablón principal de misiones |
| **Gremio - Login** | [http://localhost:8080/gremio/src/login.php](http://localhost:8080/gremio/src/login.php) | Acceso al gremio de aventureros |
| **Gremio - Zurrón** | [http://localhost:8080/gremio/src/zurron.php](http://localhost:8080/gremio/src/zurron.php) | Misiones aceptadas del aventurero |

---

## Requisitos Previos

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) instalado y en ejecución con soporte para WSL2 (en Windows).
- [Git](https://git-scm.com/) para clonar y gestionar el repositorio.
- Navegador web moderno (Chrome, Firefox, Edge).
