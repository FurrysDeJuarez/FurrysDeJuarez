'use strict';

/**
 * Recibe la llamada del script y enruta al módulo correspondiente
 *
 * @param {env} process.env
 */
(async function main(env) {
  debugger
  // CMD line arguments
  const args = process.argv.slice(2)
  let command = null, payload = null, argv = null
  while (argv = args.shift()) {
    switch (true) {
      case argv.startsWith('--command='):
        command = argv.substring(10)
        command = command.toLowerCase().split('"').join('')
        break
      case argv.startsWith('--payload='):
        payload = argv.substring(10)
        payload = payload.split('"').join('')
        break
    }
  }

  // Import constants
  // const fs = require('fs')
  const fs = await import('fs')

  switch (command) {
    case 'telegram-message':
      (await import('./telegram.esm.js')).default(
        JSON.parse(fs.readFileSync(payload, 'utf8'))
      )
      break
    case 'test':
      console.log('Test command received with payload:', payload)
      break
    default:
      console.log('No command received')
      break
  }
})((await import('dotenv')).config());
