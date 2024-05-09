<?php

$body = function () {
    ?>
    <div class="container">
      <h1>Furrys de Juárez!</h1>
      <p>Aún estoy construyendo esta madre.</p>
    </div>
    <?php
};

view('components/template', [
  'title' => 'Inicio 🐾 Furrys de Juárez',
  'body'  => $body,
]);

