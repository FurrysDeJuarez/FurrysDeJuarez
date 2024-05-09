  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title><?= $title ?? 'Furrys de Juárez' ?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="<?= wwwPath('css/styles.css', true) ?>">
  </head>

  <body>
    <nav>
      <div class="nav-wrapper">
        <a href="/" class="brand-logo"><img src="<?= wwwPath('img/furrysdejuarez.webp') ?>" alt="Furrys de Juárez"></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
          <li><a href="sass.html">Sass</a></li>
          <li><a href="badges.html">Components</a></li>
          <li><a href="collapsible.html">JavaScript</a></li>
        </ul>
      </div>
    </nav>

    <main><?= ($body ?? function () {})() ?></main>

    <footer class="page-footer">
      <div class="container">
        <div class="row">
          <div class="col l6 s12">
            <h5 class="white-text">Footer Content</h5>
            <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
          </div>
          <div class="col l4 offset-l2 s12">
            <h5 class="white-text">Links</h5>
            <ul>
              <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
              <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
              <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
              <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="footer-copyright">
        <div class="container">
          © 2014 Copyright Text
          <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
        </div>
      </div>
    </footer>

    <script type=" text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  </body>

  </html>
