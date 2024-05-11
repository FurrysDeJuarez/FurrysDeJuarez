<?php

$body = function () { ?>
  <div class="container center-align">
    <h3>¡Oh, parece que te has perdido!</h3>
    <p>La página que buscas no se encuentra disponible.</p>
    <a href="/" class="btn">Volver al inicio</a>
  </div>
<?php };

view('components/template', [
  'title' => 'Oh no 🐾 404',
  'body'  => $body,
]);
