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
          Autor: <a href="https://bsky.app/profile/astachoiki.bsky.social">AstaChoiki</a>
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
  <div class="container center-align" style="overflow:hidden">
    <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&ctz=America%2FCiudad_Juarez&bgcolor=%23999999&showNav=0&showPrint=0&showTabs=0&mode=AGENDA&title=Furrys%20de%20Ju%C3%A1rez&hl=es_419&src=NjU3NzdlNjY0Zjg0YjJlNWE1MTY0YjM5ZjUxODUzN2NlMmY2ZDgzMTNlZmQzYWQ2N2U1OGQ3YzYxZWIxOWY5ZUBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&color=%23EF6C00" style="border-width:0;display:inline-block;width:100%;margin-top:-45px" height="320" frameborder="0" scrolling="no"></iframe>
  </div>
  <div class="container">
    <h3>Algunos miembros de nuestra comunidad</h3>
  </div>
  <div class="center-align card-group">
    <div class="card">
      <div class="round-images">
        <img src="https://github.com/perritu.png" alt="Ángel" style="background-color: #fff;border-color:#fff">
      </div>
      <div class="card-content">
        <p class="center-align">Ángel</p>
        <div class="center-align">
          <a href="https://github.com/Perritu" target="_blank" class="social-btn fa-brands fa-github" title="Github@perritu"></a>
          <a href="https://twitch.tv/perritu" target="_blank" class="social-btn fa-brands fa-twitch" title="Twitch@perritu"></a>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="round-images">
        <img src="<?= wwwPath('img/avatar/AstaChoiki.webp', true) ?>" alt="AstaChoiki" style="border-color: #fed">
      </div>
      <div class="card-content">
        <p class="center-align">AstaChoiki</p>
        <div class="center-align">
          <a href="https://bsky.app/profile/astachoiki.bsky.social" target="_blank" class="social-btn fa-brands fa-bluesky" title="Bsky@astachoiki.bsky.social"></a>
          <a href="https://t.me/astachoikiwips" target="_blank" class="social-btn fa-brands fa-telegram" title="Telegram@astachoikiwips"></a>
          <a href="https://twitter.com/bakucreeper" target="_blank" class="social-btn fa-brands fa-twitter" title="Twitter@bakucreeper"></a>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="round-images">
        <img src="<?= wwwPath('img/avatar/konan.webp', true) ?>" alt="Konan Wolfpard" style="border-color:#fff">
      </div>
      <div class="card-content">
        <p class="center-align">Konan Wolfpard</p>
        <div class="center-align">
          <a href="https://bsky.app/profile/konanwolfpard.bsky.social" target="_blank" class="social-btn fa-brands fa-bluesky" title="Bsky@konanwolfpard.bsky.social"></a>
          <a href="https://www.facebook.com/profile.php?id=100069752913094" target="_blank" class="social-btn fa-brands fa-facebook" title="Facebook@konanwolfpard"></a>
          <a href="https://www.furtrack.com/user/KonanWolfpard/crafting" target=_blank" class="social-btn fa-solid fa-paw" title="FurTrack@KonanWolfpard"></a>
          <a href=" https://twitter.com/konanwolfpard" target="_blank" class="social-btn fa-brands fa-twitter" title="Twitter@konanwolfpard"></a>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="round-images">
        <img src="<?= wwwPath('img/avatar/NekoShinymoon.webp', true) ?>" alt="Shinymoon" style="border-color:#888">
      </div>
      <div class="card-content">
        <p class="center-align">Shinymoon</p>
        <div class="center-align">
          <a href="https://www.tiktok.com/@nekoshinymoon" target="_blank" class="social-btn fa-brands fa-tiktok" title="TikTok@nekoshinymoon"></a>
          <a href="https://twitter.com/NekoShinymoon" target="_blank" class="social-btn fa-brands fa-twitter" title="Twitter@NekoShinymoon"></a>
          <a href="https://www.instagram.com/shinymoonneko/" target="_blank" class="social-btn fa-brands fa-instagram" title="Instagram@shinymoonneko"></a>
          <a href="https://www.twitch.tv/nekoshinymoon" target="_blank" class="social-btn fa-brands fa-twitch" title="Twitch@nekoshinymoon"></a>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="round-images">
        <img src="<?= wwwPath('img/avatar/startgen.webp', true) ?>" alt="StartGenK9" style="border-color:#888">
      </div>
      <div class="card-content">
        <p class="center-align">StartGenK9</p>
        <div class="center-align">
          <a href="https://t.me/StartGenK9" target="blank" class="social-btn fa-brands fa-telegram" title="Telegram@StartGenK9"></a>
          <a href="https://twitter.com/StartGenK9" target="_blank" class="social-btn fa-brands fa-twitter" title="Twitter@StartGenK9"></a>
        </div>
      </div>
    </div>
  </div>
<?php };

view('components/template', [
  'title' => 'Inicio 🐾 Furrys de Juárez',
  'body'  => $body,
]);
