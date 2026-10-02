<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Erabiltzailea editatu | Administrazioa</title>
    <link rel="stylesheet" href="<?= e(asset('css/administrazioa.css')) ?>">
</head>
<body>
    <header class="topbar">
        <a class="brand" href="<?= e(route('administrazioa')) ?>">ADMINISTRAZIOA</a>
        <a href="<?= e(route('home')) ?>">Ikastaroak</a>
    </header>
    <main class="dashboard course-editor">
        <h1>Erabiltzailea editatu</h1>
        <?php if ($errors->any()): ?>
            <div class="error" role="alert"><?php foreach ($errors->all() as $error): ?><p><?= e($error) ?></p><?php endforeach; ?></div>
        <?php endif; ?>
        <form class="student-panel user-form" method="post" action="<?= e(route('users.update', $erabiltzailea)) ?>">
            <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
            <input type="hidden" name="_method" value="PATCH">
            <label for="izena">Izena</label>
            <input id="izena" name="izena" value="<?= e(old('izena', $erabiltzailea->izena)) ?>" maxlength="255" required>
            <label for="abizenak">Abizenak</label>
            <input id="abizenak" name="abizenak" value="<?= e(old('abizenak', $erabiltzailea->abizenak)) ?>" maxlength="255" required>
            <label for="emaila">Helbide elektronikoa</label>
            <input id="emaila" name="emaila" type="email" value="<?= e(old('emaila', $erabiltzailea->emaila)) ?>" maxlength="255" required>
            <label for="id_rola">Rola</label>
            <select id="id_rola" name="id_rola" required>
                <?php foreach ($rolak as $rola): ?>
                    <option value="<?= e($rola->id_rola) ?>" <?= (string) old('id_rola', $erabiltzailea->id_rola) === (string) $rola->id_rola ? 'selected' : '' ?>><?= e($rola->rola_izena) ?></option>
                <?php endforeach; ?>
            </select>
            <label for="aktibo">Kontuaren egoera</label>
            <select id="aktibo" name="aktibo" required>
                <option value="1" <?= (string) old('aktibo', $erabiltzailea->aktibo) === '1' ? 'selected' : '' ?>>Aktibo</option>
                <option value="0" <?= ! old('aktibo', $erabiltzailea->aktibo) ? 'selected' : '' ?>>Ez aktibo</option>
            </select>
            <?php if (auth()->id() === $erabiltzailea->id_erabiltzailea): ?>
                <p class="subtitle">Zure kontuak aktibo eta administratzaile izaten jarraitu behar du.</p>
            <?php endif; ?>
            <div class="course-admin-actions">
                <button type="submit">Aldaketak gorde</button>
                <a class="button-link secondary" href="<?= e(route('administrazioa')) ?>">Utzi</a>
            </div>
        </form>
    </main>
</body>
</html>
