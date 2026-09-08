<h1><?= e($salle->nom) ?></h1>
<dl>
    <dt>Bâtiment</dt><dd><?= e($salle->batiment) ?></dd>
    <dt>Capacité</dt><dd><?= e($salle->capacite) ?></dd>
    <dt>Type</dt><dd><?= e($salle->type) ?></dd>
    <dt>État</dt><dd><span class="status <?= $salle->active ? '' : 'inactive' ?>"><?= $salle->active ? 'Active' : 'Inactive' ?></span></dd>
</dl>
<div class="actions">
    <a class="button" href="/salles/<?= e($salle->id) ?>/edit">Modifier</a>
    <a class="button secondary" href="/salles">Retour</a>
</div>
