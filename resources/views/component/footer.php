  <footer>
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-8">
          <p>
            Desarrollado por <a href="https://angelgarcia.dev" target="_blank" rel="noopener noreferrer">Angel Garcia</a>.
          </p>
          <p>
            Creado con
            <a href="https://getbootstrap.com/" class="fa-brands fa-bootstrap"></a>
            <a href="https://www.php.net/" class="fa-brands fa-php"></a>
            y mucho chochomilk. <br>
            Código disponible en <a href="https://github.com/furrysdejuarez/furrysdejuarez" target="_blank"
              rel="noopener noreferrer" class="fa-brands fa-github"></a>.
          </p>
        </div>
        <div class="col-12 col-md-4">
          <p class="text-end">
            Siguenos en
            <a href="https://www.facebook.com/profile.php?id=61576208177265" class="fa-brands fa-facebook"></a>
            <a href="https://www.tiktok.com/@furrysjuarez" class="fa-brands fa-tiktok"></a>
            <a href="https://t.me/furrysjuarez" class="fa-brands fa-telegram"></a>
          </p>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/js/bootstrap.min.js"></script>
  <?php foreach ($aScripts ?? [] as $cScript) : ?>
    <script src="<?= $cScript ?>"></script>
  <?php endforeach; ?>
  </body>

  </html>
