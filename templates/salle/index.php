<div class="page-heading">
    <div>
        <p class="eyebrow">Espaces disponibles</p>
        <h1>Salles</h1>
        <p class="subtitle">Gérez vos salles et consultez leur disponibilité.</p>
    </div>
</div>
<?php
$activeCount = count(array_filter($salles, static fn ($salle): bool => (bool) $salle->active));
$totalCapacity = array_sum(array_map(static fn ($salle): int => (int) $salle->capacite, $salles));
?>
<section class="stats-grid" aria-label="Résumé des salles">
    <article class="stat-card">
        <span class="stat-icon blue">⌂</span>
        <div><strong><?= e(count($salles)) ?></strong><span>Salles au total</span></div>
    </article>
    <article class="stat-card">
        <span class="stat-icon green">✓</span>
        <div><strong><?= e($activeCount) ?></strong><span>Salles actives</span></div>
    </article>
    <article class="stat-card">
        <span class="stat-icon purple">♧</span>
        <div><strong><?= e($totalCapacity) ?></strong><span>Places disponibles</span></div>
    </article>
</section>
<div class="actions">
    <a class="button" href="/salles/create">Créer une salle</a>
    <a class="button secondary" href="/reservations/create">Créer une réservation</a>
</div>
<?php if ($salles === []): ?>
    <div class="empty-state">
        <span class="empty-icon">⌂</span>
        <h2>Aucune salle enregistrée</h2>
        <p>Commencez par ajouter une salle à votre espace.</p>
        <a class="button" href="/salles/create">Ajouter une salle</a>
    </div>
<?php else: ?>
    <section class="room-grid">
        <?php foreach ($salles as $salle): ?>
            <article class="room-card">
                <div class="room-card-top">
                    <span class="room-symbol">⌂</span>
                    <span class="status <?= $salle->active ? '' : 'inactive' ?>"><?= $salle->active ? 'Active' : 'Inactive' ?></span>
                </div>
                <p class="room-type"><?= e($salle->type) ?></p>
                <h2><?= e($salle->nom) ?></h2>
                <p class="room-location">Bâtiment <?= e($salle->batiment) ?></p>
                <div class="room-meta"><span>👥 <?= e($salle->capacite) ?> places</span><span><?= $salle->active ? 'Disponible' : 'Indisponible' ?></span></div>
                <div class="room-actions">
                    <a class="button small" href="/salles/<?= e($salle->id) ?>">Voir la salle</a>
                    <a class="icon-link" href="/salles/<?= e($salle->id) ?>/edit" aria-label="Modifier">•••</a>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
