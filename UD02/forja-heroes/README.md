# UD02: Reto «Forja de Héroes» y «Gremio»

Entorno contenerizado con **Nginx** y **PHP 8.4-FPM** sobre Alpine Linux para las prácticas de servidor de la UD02.

- **Alumno:** Marco García Ruiz
- **Variante:** B · Hechicero (`Aldric <el Arcano>`)

---

## Despliegue del Entorno

Para levantar el servidor web y PHP:

```bash
docker compose up -d
```

Para detener los contenedores:
```bash
docker compose down
```

---

## Proyectos Incluidos

### 1. Forja de Héroes
Ficha técnica del personaje Hechicero con cálculos matemáticos, barras dinámicas Unicode y tipado estricto:
- **Ficha:** [http://localhost:8080/ficha.php](http://localhost:8080/ficha.php)
- **Diagnóstico:** [http://localhost:8080/diagnostico.php](http://localhost:8080/diagnostico.php)
- **Memoria técnica detallada:** Consulta [MEMORIA.md](MEMORIA.md) con las respuestas del reto y capturas de comprobación.

### 2. Gremio de Aventureros (UD3 · UD4 · UD5)
Ubicado en la subcarpeta [`src/gremio/`](src/gremio/):
- **Tablón:** [http://localhost:8080/gremio/src/](http://localhost:8080/gremio/src/)
- **Login:** [http://localhost:8080/gremio/src/login.php](http://localhost:8080/gremio/src/login.php)
- **Base de datos:** [sql/gremio.sql](src/gremio/sql/gremio.sql)
- **Documentación del Gremio:** Consulta [src/gremio/LEEME.md](src/gremio/LEEME.md).
