<h1>Réservation #<?= e($reservation->id) ?></h1>
<?php if ($reservation->statut === 'annulée'): ?><p class="error">Cette réservation est annulée.</p><?php endif; ?>
<dl>
    <dt>Responsable</dt><dd><?= e($reservation->responsable) ?></dd>
    <dt>Email</dt><dd><?= e($reservation->email) ?></dd>
    <dt>Motif</dt><dd><?= e($reservation->motif) ?></dd>
    <dt>Début</dt><dd><?= e($reservation->date_debut) ?></dd>
    <dt>Fin</dt><dd><?= e($reservation->date_fin) ?></dd>
    <dt>Statut</dt><dd><?= e($reservation->statut) ?></dd>
</dl>
<?php if ($reservation->statut !== 'annulée'): ?>
    <form method="post" action="/reservations/<?= e($reservation->id) ?>/cancel">
        <button type="submit">Annuler la réservation</button>
    </form>
<?php endif; ?>
<div class="actions">
    <a class="button secondary" href="/reservations">Retour</a>
</div>
