# Conducta de código para furrysdejuarez/furrysdejuarez

Este es un breve descripción de la conducta de código usada por este proyecto.

## Ajustes de estilos (IDE)

Idealmente, el editor que se use debería soportar y usar el archivo `.editorconfig` para configurar el estilo de código.

Los ajustes de estilo son los siguientes:

- **Indentado**: 2 espacios
- **Longitud de línea**: 120 caracteres
- **Nombres de variables**: Notación hungara
- **Nombres de clases, métodos y funciones**: PascalCase
- **Nombres de constantes**: UPPERCASE

### Notación hungara

Los siguientes prefijos son usados para nombres de variables:

| Prefix | Description             | Example               |
| ------ | ----------------------- | --------------------- |
| `$a`   | Arreglos                | `array $aList`        |
| `$b`   | Boleanos                | `bool $bTerminated`   |
| `$c`   | Textos                  | `string $cName`       |
| `$i`   | Enteros para índices    | `int $iId`            |
| `$n`   | Enteros para conteo     | `int $nCount`         |
| `$u`   | Enteros sin signo       | `int $uId`            |
| `$f`   | Núm. flotantes o dobles | `float $fCalc`        |
| `$r`   | Recursos                | `$rFile = fopen(...)` |

Los prefijos siguientes se agregan a la notación estandar de CS o Cpp:

| Prefix | Description            | Ejemplo                  |
| ------ | ---------------------- | ------------------------ |
| `$bit` | Banderas de bits       | `int $bitFlags`          |
| `$err` | Excepciones            | `catch (Exception $err)` |
| `$o`   | Objetos                | `object $oObject`        |
| `$m`   | Indefinidos (mixed)    | --                       |

## Documentación

Al escribir o actualizar la documentación, hacerlo en español y seguir la norma de PHP para páginas de documentación.

Agregar cada entrada en su propio archivo en la carpeta `docs`. El nombre de la entrada debe ser el mismo que la clase
que documenta.
