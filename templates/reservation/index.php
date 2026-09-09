<div class="page-heading">
    <div>
        <p class="eyebrow">Planning</p>
        <h1>Réservations</h1>
        <p class="subtitle">Retrouvez et gérez toutes vos réservations.</p>
    </div>
</div>
<div class="actions">
    <a class="button" href="/reservations/create">Créer une réservation</a>
    <a class="button secondary" href="/salles">Voir les salles</a>
</div>
<?php if ($reservations === []): ?>
    <div class="empty-state">
        <span class="empty-icon">▣</span>
        <h2>Aucune réservation</h2>
        <p>Votre planning est libre pour le moment.</p>
        <a class="button" href="/reservations/create">Créer une réservation</a>
    </div>
<?php else: ?>
    <table>
        <thead><tr><th>Salle</th><th>Responsable</th><th>Début</th><th>Fin</th><th>Statut</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?= e($reservation->salle?->nom ?? 'Salle inconnue') ?></td>
                <td><?= e($reservation->responsable) ?></td>
                <td><?= e($reservation->date_debut) ?></td>
                <td><?= e($reservation->date_fin) ?></td>
                <td><span class="status <?= $reservation->statut === 'annulée' ? 'cancelled' : '' ?>"><?= e($reservation->statut) ?></span></td>
                <td><a href="/reservations/<?= e($reservation->id) ?>">Voir</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
