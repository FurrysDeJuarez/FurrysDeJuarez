<?php View('component.header', [
  'cTitle' => 'Inicio',
  'aMetatags' => [
    [
      'name' => 'description',
      'content' => 'Bienvenido a la comunidad Furrys de Juárez. Aquí encontrarás información sobre nuestra comunidad y eventos.'
    ],
    ['name' => 'keywords', 'content' => 'furry, juarez, comunidad, eventos'],
    // ['name' =>
  ],
]); ?>

<body>
  <?php View('component.navbar'); ?>
  <main>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h1>Bienvenido a la manada de furritos de la frontera</h1>
        </div>
        <div class="col-12 col-md-4 col-lg-3 order-md-2">
          <div class="center" style="text-align: center;background: #0009;border-radius: 10px;color:#fff">
            <img src="<?= Asset('img/logo-comunidad.webp') ?>" alt="Logo de la comunidad Furrys de Juárez" class="img-fluid"
              fetchpriority="high" aria-label="Logo de la comunidad Furrys de Juárez"> <br>
            <small>Logo de la comunidad Furrys de Juárez. <br> Diseñado por
              <a href="https://x.com/bakucreeper" target="_blank" class="text-white">AstaChoiki</a>
            </small>
          </div>
        </div>
        <div class="col-12 col-md-8 col-lg-9 order-md-1">
          &nbsp;<br> <!-- Truco mañoso para separar el texto del logo (o del título) -->
          <div style="text-align: center">
            Únete a la manada en nuestros espacios online <br>
            <a href="https://discord.gg/qJfyNAHNWD" target="_blank" class="btn" style="background:#5865f2;color: #fff"><i class="fab fa-discord"></i> Discord</a>
            <a href="https://www.facebook.com/groups/174033883419156" target="_blank" class="btn" style="background:#1877f2;color: #fff"><i class="fab fa-facebook"></i> Facebook</a>
            <a href="https://t.me/+Dlol6Xd58AdjNDYx" target="_blank" class="btn" style="background:#0088cc;color: #fff"><i class="fab fa-telegram"></i> Telegram</a><br>
          </div>
          <p>
            <strong>FAQ: ¿Que es un furry?</strong><br>
            Un furry es un animal con características humanas. A grandes razgos, puedes pensar en el Tigre Toño, Goyo de los Bravos de Juárez o el Pato Donald. <br>
            También se nos llama <b>Furry</b> o <b>Furro</b> a los entusiastas de dichos animales.
          </p>
          <p>
            <strong>FAQ: Fandom furry o Furdom</strong><br>
            Somos una comunidad formada por personas que comparten intereses en los furry. Principalmente en el arte y literatura, creación de personajes y eventos
            en torno a ellos. <br>
            ¿Ya conoces a <i>Beanitez</i>, nuestro personaje oficial?
          </p>
        </div>
      </div>
    </div>
    <div class="parallax" style="background-image: url('<?= Asset('img/photo_2026-05-18_00-47-07.jpg') ?>');">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <h2>Quienes somos</h2>
            <p>
              FurrysDeJuarez somos un grupo de furros de la frontera norte de México, en la ciudad de Juárez, Chihuahua. <br>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur vero atque tempore animi quas dignissimos quaerat, quia tenetur veritatis architecto, non debitis odio hic eaque cumque placeat ullam perspiciatis autem?
            </p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-12">
            <h2>Meets y eventos</h2>
            <iframe style="border: 0;width: 100%;height: 600px;" frameborder="0" scrolling="no"
              src="https://calendar.google.com/calendar/embed?src=65777e664f84b2e5a5164b39f518537ce2f6d8313efd3ad67e58d7c61eb19f9e%40group.calendar.google.com&ctz=America%2FCiudad_Juarez">
            </iframe>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php View('component.footer'); ?>
</body>

</html>
