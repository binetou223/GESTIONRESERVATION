<?php
$value = static fn (string $field): string => e($old[$field] ?? '');
?>
<h1><?= e($title) ?></h1>
<?php if (isset($errors['global'])): ?><p class="error"><?= e($errors['global']) ?></p><?php endif; ?>
<form method="post" action="<?= e($action) ?>">
    <label>Salle
        <select name="salle_id" required>
            <option value="">Choisir une salle</option>
            <?php foreach ($salles as $salle): ?>
                <?php if ($salle->active): ?><option value="<?= e($salle->id) ?>" <?= $value('salle_id') === (string) $salle->id ? 'selected' : '' ?>><?= e($salle->nom) ?></option><?php endif; ?>
            <?php endforeach; ?>
        </select>
    </label>
    <?php if (isset($errors['salle_id'])): ?><p class="error"><?= e($errors['salle_id']) ?></p><?php endif; ?>
    <label>Responsable <input name="responsable" value="<?= $value('responsable') ?>" required></label>
    <?php if (isset($errors['responsable'])): ?><p class="error"><?= e($errors['responsable']) ?></p><?php endif; ?>
    <label>Email <input type="email" name="email" value="<?= $value('email') ?>" required></label>
    <?php if (isset($errors['email'])): ?><p class="error"><?= e($errors['email']) ?></p><?php endif; ?>
    <label>Motif <textarea name="motif" required><?= $value('motif') ?></textarea></label>
    <?php if (isset($errors['motif'])): ?><p class="error"><?= e($errors['motif']) ?></p><?php endif; ?>
    <label>Début <input type="datetime-local" name="date_debut" value="<?= e(str_replace(' ', 'T', substr($old['date_debut'] ?? '', 0, 16))) ?>" required></label>
    <?php if (isset($errors['date_debut'])): ?><p class="error"><?= e($errors['date_debut']) ?></p><?php endif; ?>
    <label>Fin <input type="datetime-local" name="date_fin" value="<?= e(str_replace(' ', 'T', substr($old['date_fin'] ?? '', 0, 16))) ?>" required></label>
    <?php if (isset($errors['date_fin'])): ?><p class="error"><?= e($errors['date_fin']) ?></p><?php endif; ?>
    <button type="submit">Enregistrer la réservation</button>
</form>
