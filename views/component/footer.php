  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/js/bootstrap.min.js"></script>
  <?php foreach ($aScripts ?? [] as $cScript) : ?>
    <script src="<?= $cScript ?>"></script>
  <?php endforeach; ?>
</body>

</html>
