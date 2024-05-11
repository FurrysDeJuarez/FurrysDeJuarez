<?php

/**
 * Grupo de funciones utilitarias.
 */

// /**
//  * Regresa una ruta un archivo www en public, y opcionalmente un hash al final (cache-busting).
//  *
//  * @param string $path      Ruta relativa del archivo en la carpeta public.
//  * @param bool   $hashCache Indica si se debe agregar un hash al final de la ruta para cache-busting.
//  */
// function publicPath($path, $hashCache = false)
// {
//   $file = PUBLIC_DIR . "/" . ltrim($path, '/');
//   $wwwPath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . "/" . ltrim($path, '/');

//   if ($hashCache) {
//     $wwwPath .= "?h=" . hash_file('crc32', $file);
//   }

//   return $wwwPath;
// }

/**
 * Regresa la ruta absoluta a un archivo del proyecto.
 *
 * @param string $path Ruta relativa del archivo en el proyecto.
 * @return string|null Ruta absoluta del archivo, o null si no existe.
 */
function rootPath($path): string | null
{
  return realpath(ROOT_DIR . "/" . ltrim($path, '/')) ??  null;
}

/**
 * Regresa la ruta absoluta a un archivo en `public`
 */
function publicPath($path): string | null
{
  return rootPath('public/' . ltrim($path, '/'));
}

/**
 * Renderiza una vista (archivo de plantilla) y la incluye en la salida.
 *
 * @param string $view Nombre de la vista a renderizar (sin la extensión .php).
 * @param array $data Datos que se extraerán como variables en la vista.
 *
 * @throws Exception Si la vista especificada no existe.
 *
 * @return void
 */
function view($view, $data = []): void
{
  $viewPath = rootPath("resources/views/$view.php");
  if ($viewPath !== null) {
    extract($data, EXTR_OVERWRITE);
    require $viewPath;
  } else {
    throw new Exception("View '$view' not found.");
  }
}

/**
 * Regresa una ruta de navegación a un archivo en `public`, y opcionalmente un hash al final (cache-busting).
 *
 * @param string $path      Ruta relativa del archivo en la carpeta public.
 * @param bool   $hashCache Indica si se debe agregar un hash al final de la ruta para cache-busting.
 */
function wwwPath($path, $hashCache = false): string | null
{
  $file = publicPath($path);
  $naturalPath = substr($file, strlen(PUBLIC_DIR) + 1);

  if ($hashCache && $file !== null) {
    $naturalPath .= "?crc32=" . hash_file('crc32', $file);
  }

  return $naturalPath;
}
