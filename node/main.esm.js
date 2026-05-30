'use strict';

/**
 * Recibe la llamada del script y enruta al módulo correspondiente
 *
 * @param {env} process.env
 */
(async function main(env) {
  debugger

  // Familia de constantes
  const fs = await import('fs'),
    path = await import('path'),
    Telegram = (await import('./telegram.esm.js')).default,
    // Rutas del proyecto
    ROOT_PATH = path.dirname(import.meta.url).replace('file://', '').replace(/\/[^\/]*$/, ''),
    STORAGE_PATH = path.join(ROOT_PATH, 'storage'),
    CACHE_PATH = path.join(STORAGE_PATH, 'Cache'),
    Env = JSON.parse(fs.readFileSync(path.join(CACHE_PATH, 'environment.json'), 'utf8'))


  // Singleton general.
  const oSingleton = { fs, path, Telegram, Env, ROOT_PATH, STORAGE_PATH, CACHE_PATH }

  // Método tramposo para exponer el Singleton a Telegram.
  oSingleton.Telegram.oSingleton = oSingleton

  /**
   * Regresa una variable de entorno.
   *
   * @param {String} cKey Nombre de la variable
   * @param {*} mDefault  Valor a regresar si no existe una variable cKey
   * @returns {*}
   */
  oSingleton.fnEnv = (cKey, mDefault = null) => {
    return oSingleton.Env[cKey] ?? process.env[cKey] ?? mDefault
  }

  debugger
  // Gestionar las líneas de comando
  let argv = process.argv.slice(2),
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

  const oTargetInstance = oSingleton[command]
  if (oTargetInstance) {
    // oTargetInstance({ command, payload })
    console.log(`Módulo "${command}" encontrado`)
    oTargetInstance?.fnDispatch?.(payload)
  } else {
    console.error(`Módulo "${command}" no encontrado`)
  }
})();
