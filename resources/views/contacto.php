<?php

$body = function () { ?>
  <div class="container">
    <h1>Contacto</h1>
    <p>
      Bien... esto es vergonzoso...<br>
      Aún no hemos implementado la sección de contacto, pero puedes comunicarte
      con nosotros a través de nuestros canales oficiales. Encuentralos en el
      pie de página.
    </p>
  </div>
<?php };

view('components/template', [
  'title' => 'Conta­cto 🐾 Furrys de Juárez',
  'body'  => $body,
]);
