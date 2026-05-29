<?php
// Preconect
header('Link: <https://cdnjs.cloudflare.com>; rel="preconnect"', false);
header('Link: <https://fonts.bunny.net>; rel="preconnect"', false);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <title><?= $cTitle ?? 'Sin título' ?> | Furrys de Juarez</title>

  <!-- HTML Meta Tags -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Furrys de Juarez - Comunidad de furries en Juárez">

  <!-- Open Graph Meta Tags -->
  <meta property="og:url" content="https://canary.furrysdejuarez.com/">
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?= $cTitle ?? 'Sin título' ?> | Furrys de Juarez">
  <meta property="og:description" content="Furrys de Juarez - Comunidad de furries en Juárez">
  <meta property="og:image" content="https://canary.furrysdejuarez.com/<?= Asset('img/logo-comunidad.webp') ?>">

  <!-- Twitter Meta Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta property="twitter:domain" content="canary.furrysdejuarez.com">
  <meta property="twitter:url" content="https://canary.furrysdejuarez.com/">
  <meta name="twitter:title" content="<?= $cTitle ?? 'Sin título' ?> | Furrys de Juarez">
  <meta name="twitter:description" content="Furrys de Juarez - Comunidad de furries en Juárez">
  <meta name="twitter:image" content="https://canary.furrysdejuarez.com/<?= Asset('img/logo-comunidad.webp') ?>">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <?php foreach ($aMetatags ?? [] as $aMetatag): ?>
    <meta name="<?= $aMetatag['name'] ?>" content="<?= $aMetatag['content'] ?>">
  <?php endforeach; ?>

  <link rel="canonical" href="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  <link rel="stylesheet" href="<?= Asset('css/styles.css') ?>">
</head>
