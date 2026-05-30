'use strict';

// export default function(payload){
//   debugger
// }

const telegram = new (function TelegramWrapper() { })()

telegram.fnDispatch = function (payload) {
  debugger
  console.log(telegram)
}

export default telegram
