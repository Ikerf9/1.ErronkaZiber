<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ikastaroak | Ikastetxea</title>
    <link rel="stylesheet" href="<?= e(asset('css/administrazioa.css')) ?>">
</head>
<body class="student-page">
<header class="topbar">
    <a class="brand" href="<?= e(route('home')) ?>">IKASTETXEA</a>
    <nav class="account" aria-label="Menu nagusia">
        <?php if (auth()->check()): ?>
            <span><?= e(auth()->user()->izena) ?></span>
            <?php if (auth()->user()->rola?->rola_izena === 'admin'): ?>
                <a href="<?= e(route('administrazioa')) ?>">Administrazioa</a>
            <?php endif; ?>
            <form method="post" action="<?= e(route('logout')) ?>">
                <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                <button class="secondary" type="submit">Saioa itxi</button>
            </form>
        <?php else: ?>
            <a href="<?= e(route('login')) ?>">Saioa hasi</a>
            <a class="button-link" href="<?= e(route('register')) ?>">Erregistratu</a>
        <?php endif; ?>
    </nav>
</header>
<main class="dashboard">
    <section class="page-hero" aria-labelledby="page-title">
        <div class="hero-copy">
            <span class="eyebrow">IKASI ETA HAZI</span>
            <h1 id="page-title">Aurkitu zure hurrengo ikastaroa</h1>
            <p class="subtitle">Ezagutu ikastetxeko ikastaro guztiak eta aukeratu zure bidea.</p>
            <a class="button-link hero-button" href="#ikastaroak">Ikastaroak arakatu <span aria-hidden="true">&rarr;</span></a>
        </div>
        <div class="hero-summary">
            <span class="summary-label">ZURE HURRENGO PAUSOA</span>
            <strong class="summary-number"><?= e($ikastaroak->count()) ?></strong>
            <span>ikastaro zure aukeran</span>
            <div class="summary-footer">Ikasi. Garatu. Aurrera egin.</div>
        </div>
    </section>
    <?php if (session('status')): ?><p class="success" role="status"><?= e(session('status')) ?></p><?php endif; ?>
    <?php if ($errors->any()): ?>
        <div class="error" role="alert"><?php foreach ($errors->all() as $error): ?><p><?= e($error) ?></p><?php endforeach; ?></div>
    <?php endif; ?>
    <div class="catalog-heading" id="ikastaroak"><h2>Ikastaro guztiak</h2><span class="count"><?= e($ikastaroak->count()) ?> ikastaro</span></div>
    <div class="course-grid">
    <?php foreach ($ikastaroak as $ikastaroa): ?>
        <article class="course-card">
            <span class="eyebrow">IKASTAROA</span>
            <h2><?= e($ikastaroa->izenburua) ?></h2>
            <p class="subtitle"><?= e($ikastaroa->deskribapena) ?></p>
            <dl class="course-details">
                <div><dt>Hasiera</dt><dd><?= e($ikastaroa->hasiera_data) ?></dd></div>
                <div><dt>Amaiera</dt><dd><?= e($ikastaroa->amaiera_data) ?></dd></div>
                <div><dt>Plaza libreak</dt><dd><?= e(max(0, $ikastaroa->edukiera - $ikastaroa->matrikulak_count)) ?> / <?= e($ikastaroa->edukiera) ?></dd></div>
            </dl>
            <div class="course-action">
            <?php if (auth()->user()?->rola?->rola_izena === 'ikasleak' && auth()->user()->aktibo): ?>
                <?php if (($matrikulatuta[$ikastaroa->id_ikastaroa] ?? null) === 'aktibo'): ?>
                    <span class="badge active">Matrikulatuta zaude</span>
                <?php elseif (array_key_exists($ikastaroa->id_ikastaroa, $matrikulatuta)): ?>
                    <span class="badge inactive">Matrikula ez dago aktibo</span>
                    <p class="access-note">Berriz aktibatzeko, jarri harremanetan administratzailearekin.</p>
                <?php elseif ($ikastaroa->matrikulak_count >= $ikastaroa->edukiera): ?>
                    <button disabled>Plazak agortuta</button>
                <?php else: ?>
                    <form method="post" action="<?= e(route('enroll', $ikastaroa)) ?>">
                        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                        <button type="submit">Matrikulatu</button>
                    </form>
                <?php endif; ?>
            <?php elseif (! auth()->check()): ?>
                <a href="<?= e(route('login')) ?>">Hasi saioa matrikulatzeko &rarr;</a>
            <?php endif; ?>
            </div>
            <?php if (auth()->user()?->rola?->rola_izena === 'admin'): ?>
                <?= view('ikastaroko-ikasleak', ['ikastaroa' => $ikastaroa])->render() ?>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
    </div>
    <?php if ($ikastaroak->isEmpty()): ?><p class="empty">Oraindik ez dago ikastarorik.</p><?php endif; ?>
</main>
<?= view('student-footer')->render() ?>
</body>
</html>
