<?php

if (!function_exists('e')) {
    function e(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'Gestion de réservation') ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<header>
    <nav>
        <a class="brand" href="/salles">
            <span class="brand-mark">R</span>
            <span>Réserva<span class="brand-accent">tion</span></span>
        </a>
        <div class="nav-links">
            <a href="/salles">Salles</a>
            <a href="/reservations">Réservations</a>
        </div>
    </nav>
</header>
<main>
    <?= $content ?>
</main>
<footer>
    <p>Gestion de réservation <span>•</span> Simple, rapide, organisé</p>
</footer>
</body>
</html>