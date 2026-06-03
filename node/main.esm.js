'use strict';

/**
 * Recibe la llamada del script y enruta al módulo correspondiente
 *
 * @param {env} process.env
 */
(async function main(env) {
  // Familia de constantes.
  // Librerías
  const fs = await import('fs'),
    mysql = await import('mysql'),
    path = await import('path'),
    // Rutas
    ROOT_PATH = path.dirname(import.meta.url).replace('file://', '').replace(/\/[^\/]*$/, ''),
    STORAGE_PATH = path.join(ROOT_PATH, 'storage'),
    CACHE_PATH = path.join(STORAGE_PATH, 'Cache'),
    // Generales y auxiliares
    Environment = JSON.parse(fs.readFileSync(path.join(CACHE_PATH, 'environment.json'), 'utf8')),
    Env = function (key, fallback = null) { return process.oSingleton.Environment[`${key}`] ?? process.env[`${key}`] ?? fallback }

  process.oSingleton = {
    fs,
    mysql,
    path,
    ROOT_PATH,
    STORAGE_PATH,
    CACHE_PATH,
    Environment,
    Env,
  }

  process.oSingleton.Modules = {
    Telegram: (await import('./telegram.esm.js')).default,
  }

  // Gestionar las líneas de comando
  let argv = process.argv.slice(3),
    command = null,
    payload = null

  for (const arg of argv) {
    switch (true) {
      case arg.startsWith('--command='):
        command = arg.substring(10)
        break
      case arg.startsWith('--payload='):
        payload = JSON.parse(fs.readFileSync(arg.substring(10)))
        break
    }
  }
  const oTargetInstance = process.oSingleton.Modules[`${command ?? -1}`] ?? null
  if (oTargetInstance)
    oTargetInstance(payload)
  else
    console.error(`Módulo "${command}" no encontrado`)
})();
