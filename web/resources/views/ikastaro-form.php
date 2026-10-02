<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $ikastaroa->exists ? 'Ikastaroa editatu' : 'Ikastaro berria' ?> | Administrazioa</title>
    <link rel="stylesheet" href="<?= e(asset('css/administrazioa.css')) ?>">
</head>
<body>
    <header class="topbar">
        <a class="brand" href="<?= e(route('administrazioa')) ?>">ADMINISTRAZIOA</a>
        <a href="<?= e(route('home')) ?>">Ikastaroak</a>
    </header>
    <main class="dashboard course-editor">
        <h1><?= $ikastaroa->exists ? 'Ikastaroa editatu' : 'Ikastaro berria sortu' ?></h1>
        <?php if ($errors->any()): ?>
            <div class="error" role="alert"><?php foreach ($errors->all() as $error): ?><p><?= e($error) ?></p><?php endforeach; ?></div>
        <?php endif; ?>
        <form class="student-panel course-form" method="post" action="<?= e($ikastaroa->exists ? route('courses.update', $ikastaroa) : route('courses.store')) ?>">
            <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
            <?php if ($ikastaroa->exists): ?><input type="hidden" name="_method" value="PATCH"><?php endif; ?>
            <label for="izenburua">Izenburua</label>
            <input id="izenburua" name="izenburua" value="<?= e(old('izenburua', $ikastaroa->izenburua)) ?>" maxlength="255" required>
            <label for="deskribapena">Deskribapena</label>
            <textarea id="deskribapena" name="deskribapena" rows="4" maxlength="10000"><?= e(old('deskribapena', $ikastaroa->deskribapena)) ?></textarea>
            <div class="course-form-dates">
                <div><label for="hasiera_data">Hasiera-data</label><input id="hasiera_data" name="hasiera_data" type="date" value="<?= e(old('hasiera_data', $ikastaroa->hasiera_data)) ?>" required></div>
                <div><label for="amaiera_data">Amaiera-data</label><input id="amaiera_data" name="amaiera_data" type="date" value="<?= e(old('amaiera_data', $ikastaroa->amaiera_data)) ?>" required></div>
                <div><label for="edukiera">Plaza kopurua (1-<?= e(\App\Models\Ikastaroa::MAX_CAPACITY) ?>)</label><input id="edukiera" name="edukiera" type="number" min="1" max="<?= e(\App\Models\Ikastaroa::MAX_CAPACITY) ?>" value="<?= e(old('edukiera', $ikastaroa->edukiera)) ?>" required></div>
            </div>
            <div class="course-admin-actions">
                <button type="submit"><?= $ikastaroa->exists ? 'Aldaketak gorde' : 'Ikastaroa sortu' ?></button>
                <a class="button-link secondary" href="<?= e(route('home')) ?>">Utzi</a>
            </div>
        </form>
    </main>
</body>
</html>
