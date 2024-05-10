<?php

$body = function () { ?>
  <div class="container row">
    <div class="col s12 m6 l4 right card card-hero">
      <div class="card-image">
        <img src="<?= wwwPath('img/furrysdejuarez-hero.webp') ?>" alt="">
      </div>
      <div class="card-content">
        <p>
          Logotipo de la comunidad. <br>
          Autor: <a href="#">AstaDraws</a>
        </p>
      </div>
    </div>
    <div class="col s12 m6 l8 left">
      <h1>¿Quienes somos?</h1>
      <p>
        Somos un grupo cultural sin fines de lucro que busca promover y difundir
        la cultura furry en la ciudad de Juárez, México. <br>
        Nos enfocamos en organizar eventos, talleres y actividades relacionadas
        con el arte y la comunidad furry.
      </p>
      <p>
        Contrario a la creencia popular, no somos una ONG o asociación civil.
        Somos simplemente un grupo de amigos que comparten la pasión por la cultura
        furry. <br>
        Nos reunimos de manera informal para disfrutar de actividades relacionadas
        al fandom. Jugamos, compartimos y convivimos, siempre de forma informal,
        y ocacionalmente nos involucramos en eventos culturales y de difusión.
      </p>
    </div>
  </div>
  <div class="parallax-container" style="height: 200px;">
    <div class="parallax">
      <img src="<?= wwwPath('img/photos/photo_2023-12-28_22-05-03.webp') ?>" alt="Foto Netovens" style="width: 110vw;">
    </div>
  </div>
  <div class="container">
    <h1>Reuniones</h1>
    <p>
      Nuestras reuniones son aleatorias y casuales, a veces poniendonos de
      acuerdo el mismo día... <b>LOL</b><br>
      Te invitamos a contactarnos en nuestros
      <a href="/contacto">canáles oficiales</a> para que puedas si deseas unirte
      a nuestras reuniones o eventos.
    </p>
  </div>
<?php };

view('components/template', [
  'title' => 'Inicio 🐾 Furrys de Juárez',
  'body'  => $body,
]);
