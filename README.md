# Prácticas de Desarrollo Web en Entorno Servidor

Este repositorio contiene las prácticas y retos organizados de la asignatura:

---

## 📁 Estructura del Repositorio

### 🔹 [UD01 - Servidor con Docker](UD01/README.md)
Despliegue de un entorno de servidor web contenerizado con:
- **Nginx** como servidor web (puerto 8080).
- **PHP 8.3** (PHP-FPM con extensión PDO MySQL).
- **MySQL 8.0** para la base de datos relacional.
- Gestión orquestada mediante **Docker Compose**.

> Consulta los detalles y la guía de inicio en [UD01/README.md](UD01/README.md).

---

### 🔹 [UD02 - Reto «Forja de Héroes» y «Gremio»](UD02/forja-heroes/MEMORIA.md)
Entorno contenerizado (Nginx + PHP 8.4) con los proyectos:
- **Forja de Héroes:** Variante Hechicero (B), ficha de personaje y panel de diagnóstico.
- **[Gremio de Aventureros](UD02/forja-heroes/src/gremio/LEEME.md):** Ubicado en `UD02/forja-heroes/src/gremio/` con sistema de autenticación, tablón de misiones, zurrón, preferencias y persistencia PDO con script SQL en `sql/gremio.sql`.
- **Entregas:** Archivos `.zip` comprimidos en `UD02/entregas/`.
