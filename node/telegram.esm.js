'use strict'

const {
  CACHE_PATH,
  STORAGE_PATH,
  Env,
  mysql,
  path,
  fs,
} = process.oSingleton

let Connection = null

const Telegram = function Wrapper(payload) {
  if (Connection) return Telegram.Handle(payload)

  let Credentials = new URL(Env('DB'))
  Connection = new mysql.createConnection({
    host: Credentials.hostname,
    user: Credentials.username,
    password: Credentials.password,
    database: Credentials.pathname.substring(1)
  })

  Connection.connect(err => {
    if (err) {
      Putlog(`Error al conectar a la base de datos: ${err}`)
      process.exit(1)
    } else {
      Telegram.Handle(payload)
    }
  })
}

/**
 * Llama al API de Telegram y guarda en el log la carga y respuesta.
 *
 * @param {string} cMethod
 * @param {array} aData
 * @return {Promise(object)}
 */
const Api = function (cMethod, aData) {
  let cApikey = Env('TG_APIKEY'),
    cPayload = JSON.stringify(aData),
    cUrl = `https://api.telegram.org/bot${cApikey}/${cMethod}`

  return new Promise(async (solve, reject) => {
    await Putlog(`${cMethod} > ${cPayload}`)
    let res = await fetch(cUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: cPayload
    }).catch(err => {
      Putlog(`(e) < ${err}`)
      reject(err)
    })
    res = await res.json()
    Putlog(`${cMethod} < ${JSON.stringify(res)}`)
    solve(res)
  })
}

/**
 * Procesa los webhooks de Telegram
 *
 * @param {object} payload
 * @return {Promise(void)}
 */
Telegram.Handle = async function (payload) {
  Putlog(`(webhook) < ` + JSON.stringify(payload))
  let aKeys = Object.keys(payload)
  for (const cKey of aKeys) {
    switch (cKey) {
      case 'message':
        HandleMessage(payload.message)
        continue
      default:
        continue
    }
  }
}

/**
 * Maneja los mensajes entrantes
 *
 * @param {object} oMessage
 * @return {Promise(void)}
 */
const HandleMessage = async function (oMessage) {
  let iChatId = oMessage.chat.id,
    uMessageId = oMessage.message_id,
    uUser = oMessage.from.id,
    cUser = oMessage.from.username

  // Registra el mensaje en log y DB.
  let asyncs = [
    Putlog(`(i) UserID: ${uUser}, ChatID: ${iChatId}, Username: ${cUser}`),
    Query(
      `INSERT INTO TelegramMessage (ChatId, MessageId, UserId, Username) VALUES (${iChatId}, ${uMessageId}, ${uUser}, '${cUser}')`
      + ` ON DUPLICATE KEY UPDATE UserId = ${uUser}, Username = '${cUser}', __deleted_at = NULL`
    ),
  ]

  // Para grupos.
  if (iChatId < 0) {
    return Promise.all(asyncs)
  }

  // Comandos de Telegram
  switch (oMessage.text?.trim()?.toLowerCase()) {
    case '/start':
    case '/comenzar':
      let uHelloId = null
      asyncs.push((async () => {
        let awaiter = Api('sendChatAction', {
          chat_id: iChatId,
          action: 'typing'
        })
        let aTextMessage = ['Bienvenido a Furrys de Juarez']
        let cAppEnv = Env('APP_ENV')
        if (cAppEnv !== 'prod') {
          let mAppVersion = Env('APP_VERSION', 'SNAPSHOT')
          aTextMessage = [
            ...aTextMessage,
            '```conf',
            `APP_ENV:     ${cAppEnv}`,
            `APP_VERSION: ${mAppVersion}`,
            '```'
          ]
        } else aTextMessage.push('')

        aTextMessage = [
          ...aTextMessage,
          'Soy Beanites, mascota de la comunidad de **Furrys de Juarez**.',
          // '',
          'Conmigo puedes consultar información relacionada con tu perfil dentro de la comunidad.'.PHP_EOL,
          'Estos son los comandos disponibles:',
          '**/start**: Reinicia la sesión y muestra este mensaje. Esto **no elimina** tu información.',
          '**/bank**:  Te permite acceder a tu cuenta bancaria. (sistema de puntos)',
          '**/anon**:  Opcion para enviar un mensaje a la administración de forma anónima.',
        ]

        let cTextMessage = aTextMessage.join("\n")

        await Promise.all([awaiter])
        let res = await SendMessage(iChatId, cTextMessage)
        uHelloId = res.message_id
      })())

      await Promise.all(asyncs)
      let aIds = [],
        aRows = await Query(`SELECT MessageId FROM TelegramMessage WHERE ChatId = ${iChatId} AND __deleted_at IS NULL ORDER BY MessageId`)
      for (const oRow of aRows) {
        if (oRow.MessageId === uHelloId) continue
        aIds.push(oRow.MessageId)
      }

      await Api('deleteMessages', {
        chat_id: iChatId,
        message_ids: aIds,
      })
      break
  }
}

/**
 * Registra una entrada en el log
 *
 * @param {string} cMessage
 * @return {Promise(void)}
 */
const Putlog = async function (cMessage) {
  const cLog = path.join(STORAGE_PATH, 'Logs/Telegram.log'),
    cDate = (new Date()).toISOString().slice(0, 19).replace('T', ' ')
  let cRunID = Putlog.cRunID

  if (!cRunID) {
    let luDigit = (new Date()).getTime()
    luDigit = (luDigit << 4) + Math.floor(Math.random() * 15)
    luDigit = luDigit.toString(16).padStart(12, 0)
    Putlog.cRunID = luDigit
    cRunID = luDigit
  }

  fs.appendFileSync(cLog, `[${cDate}] ${cRunID} ${cMessage}\n`)
}

/**
 * Realiza una consulta SQL
 *
 * @param {string} cQuery
 * @return {Promise(array)}
 */
const Query = function (cQuery) {
  return new Promise((solve, reject) => {
    Connection.query(cQuery, (err, res) => {
      if (err) {
        Putlog(`Error al realizar la consulta: ${err}`)
        Putlog(`(i) Query: ${cQuery}`)
        reject(err)
      } else {
        solve(res)
      }
    })
  })
}

/**
 * Envía un mensaje a Telegram
 *
 * @param {string} iChatId
 * @param {string} cText
 * @param {array} aOptions
 * @return {ApiPromise}
 */
const SendMessage = function (iChatId, cText, aOptions = []) {
  if (aOptions['parse_mode'] === undefined) aOptions['parse_mode'] = 'MarkdownV2'
  if (aOptions['parse_mode'] === 'MarkdownV2') {
    // '_[]()~`>#+-=|{}.!
    cText = cText.replaceAll(/([_\[\](){}\~#+-=.|!])/g, '\\$1')
  }

  return new Promise(async (solve, reject) => {
    const oResult = await Api('sendMessage', {
      chat_id: iChatId,
      text: cText,
      // parse_mode: aOptions['parse_mode'] ?? 'MarkdownV2',
      ...aOptions,
    }).then(oResult => oResult.result)

    let uMessageId = oResult.message_id,
      uUserId = oResult.from.id,
      cUsername = oResult.from.username
    await Query(
      'INSERT INTO TelegramMessage (ChatId, MessageId, UserId, Username) ' +
      `VALUES (${iChatId}, ${uMessageId}, ${uUserId}, '${cUsername}') ` +
      'ON DUPLICATE KEY UPDATE __deleted_at = NULL'
    )

    solve(oResult)
  })
}

export default Telegram
