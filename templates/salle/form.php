<?php
$value = static function (string $field, mixed $default = '') use ($old, $salle): string {
    return e($old[$field] ?? ($salle?->{$field} ?? $default));
};
?>
<h1><?= e($title) ?></h1>
<form method="post" action="<?= e($action) ?>">
    <label>Nom <input name="nom" value="<?= $value('nom') ?>" required></label>
    <?php if (isset($errors['nom'])): ?><p class="error"><?= e($errors['nom']) ?></p><?php endif; ?>
    <label>Bâtiment <input name="batiment" value="<?= $value('batiment') ?>" required></label>
    <?php if (isset($errors['batiment'])): ?><p class="error"><?= e($errors['batiment']) ?></p><?php endif; ?>
    <label>Capacité <input type="number" name="capacite" value="<?= $value('capacite') ?>" min="1" required></label>
    <?php if (isset($errors['capacite'])): ?><p class="error"><?= e($errors['capacite']) ?></p><?php endif; ?>
    <label>Type
        <select name="type" required>
            <?php foreach (['cours', 'informatique', 'laboratoire', 'amphitheatre', 'reunion'] as $type): ?>
                <option value="<?= e($type) ?>" <?= $value('type') === $type ? 'selected' : '' ?>><?= e($type) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <?php if (isset($errors['type'])): ?><p class="error"><?= e($errors['type']) ?></p><?php endif; ?>
    <label><input type="checkbox" name="active" value="1" <?= ($old['active'] ?? ($salle?->active ?? true)) ? 'checked' : '' ?>> Active</label>
    <?php if (isset($errors['active'])): ?><p class="error"><?= e($errors['active']) ?></p><?php endif; ?>
    <button type="submit">Enregistrer</button>
</form>
