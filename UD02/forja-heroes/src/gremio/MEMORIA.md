# Memoria · Gremio de Aventureros

**Código de alumno/a:** MEDAC-2DAW-MGR  (no pongas tu nombre)

## 1. Mi aventurero
*(Correspondiente a la Entrega 2 / Parte 3)*
- Usuario que he añadido a la tabla: ______
- Comando o pasos que he usado para generar el hash:

## 2. Parte 1 · match
¿Has puesto `default` en `etiquetaRango()`? ¿Qué pasa si llega el rango `'Z'`? ¿Por qué lo prefieres así?

Sí, he incluido la rama `default => 'Desconocido'`. Si llegase el rango `'Z'` y no existiera la cláusula `default`, la estructura de control `match` de PHP lanzaría una excepción no capturada de tipo `UnhandledMatchError`, lo que provocaría un error fatal y la detención inmediata de la ejecución de la página.

Prefiero dejar un `default` por principios de programación defensiva y robustez en desarrollo web: aunque la entrada del usuario se filtre y valide previamente en `leerRangoFiltro()`, las funciones auxiliares de dominio deben ser seguras por sí mismas y responder de manera controlada ante cualquier valor no tipificado o posibles datos corruptos en el origen de datos.

## 3. Parte 2 · Validación de la URL
Escribe a mano en la barra `tablon.php?rango=Z&oro=hola`. ¿Qué ocurre y qué línea de tu código lo evita?

Al introducir manualmente estos parámetros en la URL, el tablón se carga con normalidad mostrando las 10 misiones disponibles, sin provocar advertencias (`Warning`), avisos (`Notice`) ni fallos de ejecución.

- **Para `rango=Z`:** En `inc/funciones.php`, la función `leerRangoFiltro()` comprueba la pertenencia con:
  ```php
  return in_array($rango, RANGOS, true) ? $rango : null;
  ```
  Al no existir `'Z'` en la constante `RANGOS`, devuelve `null`, ignorando el filtro no válido y permitiendo ver misiones de cualquier rango.

- **Para `oro=hola`:** En `inc/funciones.php`, la función `leerOroMinimo()` utiliza:
  ```php
  $valor = filter_var($get['oro'], FILTER_VALIDATE_INT, [
      'options' => [
          'min_range' => 0,
          'max_range' => 10000,
      ],
  ]);
  return ($valor !== false) ? $valor : 0;
  ```
  La cadena `'hola'` no pasa la validación de entero de `filter_var`, devolviendo `false`. La condición ternaria asigna el valor seguro `0`, evitando cualquier error de tipo o cálculo con cadenas no numéricas.

## 4. Parte 3 · Sesión frente a cookie
*(Se completará en la Entrega 2)*
Explica con tus palabras qué guardas en `$_SESSION` y qué guardas en cookies, y por qué no al revés.

## 5. Parte 3 · Seguridad del login
*(Se completará en la Entrega 2)*
- ¿Qué pasa si en el usuario escribes `' OR '1'='1`? ¿Por qué?
- ¿Para qué sirve `session_regenerate_id(true)`?
- ¿Por qué el mensaje de error es el mismo si falla el usuario o la contraseña?

## 6. Pruebas que he hecho
| Prueba | Resultado esperado | Resultado obtenido |
|---|---|---|
| Abrir `tablon.php` | Muestra 10 tarjetas con su clase de color según el rango (`facil` verde, `media` naranja, `dificil` rojo) | Superado. 10 tarjetas visualizadas con las clases CSS correspondientes. |
| Filtrar por rango B y oro mínimo 500 (`tablon.php?rango=B&oro=500`) | Muestra exactamente 2 misiones: «Bandidos del desfiladero» y «Sombras en el cementerio» | Superado. Se listan 2 misiones que cumplen ambos criterios. |
| Parámetros inválidos en URL (`tablon.php?rango=Z&oro=hola`) | Muestra las 10 misiones sin errores ni advertencias en PHP | Superado. Filtros descartados con seguridad devolviendo `null` y `0`. |
| Aceptar «Bandidos del desfiladero» y «El dragón de Obsidiana» | El zurrón muestra ambas y una suma total de recompensa de 5.650 mo | Superado. Muestra las dos misiones en la tabla con un total acumulado de 5.650 mo. |
| Aceptar la misma misión dos veces / pulsar F5 tras POST | No se duplica en el zurrón; F5 no reenvía el formulario gracias a la redirección PRG | Superado. Mensaje de aviso informativo, zurrón sin duplicados y recarga limpia sin reenvío POST. |
| Pulsar Abandonar en una misión del zurrón | Desaparece del zurrón, muestra aviso flash y recalcula el total de oro | Superado. La misión se elimina de `$_SESSION['zurron']` y el total pasa a 5.000 mo. |
| Entrar en tablon.php sin login | *(Entrega 2)* | *(Pendiente Entrega 2)* |
| Login con contraseña mala | *(Entrega 2)* | *(Pendiente Entrega 2)* |
| Cerrar sesión y volver al zurrón | *(Entrega 2)* | *(Pendiente Entrega 2)* |
| Cambiar el tema y cerrar sesión | *(Entrega 2)* | *(Pendiente Entrega 2)* |

## 7. Dificultades y cómo las he resuelto
- **Patrón Post/Redirect/Get (PRG):** Para prevenir que al pulsar F5 o recargar la página el navegador reenvíe la petición POST de aceptación o abandono de misión, implementé una redirección con encabezado HTTP `header('Location: ...')` seguido de `exit;` inmediatamente después de procesar la lógica de negocio y almacenar el mensaje temporal en `mensajeFlash()`.
- **Validación robusta con `filter_var`:** Para asegurar que el parámetro de oro estuviese estrictamente entre 0 y 10.000 mo, se configuró el array de opciones `min_range` y `max_range` con `FILTER_VALIDATE_INT`, gestionando el valor de retorno para que cualquier cadena inválida o número fuera de rango retorne por defecto 0.
- **Formateo y concordancia de cadenas:** Para la duración de las misiones se condicionó la etiqueta para mostrar «1 día» en singular y «N días» en plural, y para el oro se empleó `number_format($oro, 0, ',', '.') . ' mo'` para garantizar la separación de miles con punto según el estándar en español.
