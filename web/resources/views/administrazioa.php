<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrazioa | Erabiltzaileak</title>
    <link rel="stylesheet" href="<?= e(asset('css/administrazioa.css')) ?>">
</head>
<body>
    <header class="topbar">
        <a class="brand" href="<?= e(route('administrazioa')) ?>">ADMINISTRAZIOA</a>
        <div class="account"><a href="<?= e(route('home')) ?>">Ikastaroak</a>
            <span><?= e(auth()->user()->izena) ?></span>
            <form method="post" action="<?= e(route('logout')) ?>">
                <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                <button class="secondary" type="submit">Saioa itxi</button>
            </form>
        </div>
    </header>
    <main class="dashboard">
        <span class="eyebrow">ORRI NAGUSIA</span>
        <h1>Erabiltzaileak</h1>
        <p class="subtitle">Sisteman erregistratutako erabiltzaile guztien zerrenda.</p>
        <?php if (session('status')): ?><p class="success" role="status"><?= e(session('status')) ?></p><?php endif; ?>
        <?php if ($errors->any()): ?>
            <div class="error" role="alert"><?php foreach ($errors->all() as $error): ?><p><?= e($error) ?></p><?php endforeach; ?></div>
        <?php endif; ?>
        <section class="student-panel">
            <h2>Ikasle berria gehitu</h2>
            <p class="subtitle">Gehitu ikaslea aurrez. Ondoren, bere emailarekin erregistratu eta pasahitza aukeratu ahal izango du.</p>
            <form class="student-form" method="post" action="<?= e(route('students.store')) ?>">
                <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                <div><label for="izena">Izena</label><input id="izena" name="izena" value="<?= e(old('izena')) ?>" maxlength="255" required></div>
                <div><label for="abizenak">Abizenak</label><input id="abizenak" name="abizenak" value="<?= e(old('abizenak')) ?>" maxlength="255" required></div>
                <div><label for="emaila">Helbide elektronikoa</label><input id="emaila" name="emaila" type="email" value="<?= e(old('emaila')) ?>" maxlength="255" required></div>
                <button type="submit">Ikaslea gehitu</button>
            </form>
        </section>
        <section class="table-card" aria-label="Erabiltzaileen zerrenda">
            <div class="table-heading"><h2>Erabiltzaile guztiak</h2><span class="count"><?= e($erabiltzaileak->count()) ?> erabiltzaile</span></div>
            <div class="table-scroll" tabindex="0" role="region" aria-label="Erabiltzaileen taula">
                <table>
                    <thead><tr><th scope="col">IDa</th><th scope="col">Izena</th><th scope="col">Abizenak</th><th scope="col">Helbide elektronikoa</th><th scope="col">Rolaren IDa</th><th scope="col">Rola</th><th scope="col">Kontuaren egoera</th></tr></thead>
                    <tbody>
                    <?php foreach ($erabiltzaileak as $erabiltzailea): ?>
                        <tr>
                            <td><?= e($erabiltzailea->id_erabiltzailea) ?></td>
                            <td><?= e($erabiltzailea->izena) ?></td>
                            <td><?= e($erabiltzailea->abizenak) ?></td>
                            <td><?= e($erabiltzailea->emaila) ?></td>
                            <td><?= e($erabiltzailea->id_rola) ?></td>
                            <td><?= e($erabiltzailea->rola?->rola_izena ?? 'Rolik gabe') ?></td>
                            <td><span class="badge <?= $erabiltzailea->aktibo ? 'active' : 'inactive' ?>"><?= $erabiltzailea->aktibo ? 'Aktibo' : 'Ez aktibo' ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($erabiltzaileak->isEmpty()): ?>
                        <tr><td colspan="7" class="empty">Ez dago erabiltzaile erregistraturik.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <section class="course-management" aria-labelledby="courses-title">
            <h2 id="courses-title">Ikastaroak eta ikasleak</h2>
            <p class="subtitle">Kudeatu ikastaro bakoitzeko matrikulak. Matrikula desaktibatzeak ez du ikaslearen kontua edo beste ikastaroetako matrikularik aldatzen.</p>
            <?php foreach ($ikastaroak as $ikastaroa): ?>
                <article class="table-card course-admin-card">
                    <div class="table-heading">
                        <h3><?= e($ikastaroa->izenburua) ?></h3>
                        <span class="count"><?= e($ikastaroa->matrikulak->where('egoera', 'aktibo')->count()) ?> / <?= e($ikastaroa->edukiera) ?> plaza beteta</span>
                    </div>
                    <?= view('ikastaroko-ikasleak', ['ikastaroa' => $ikastaroa])->render() ?>
                </article>
            <?php endforeach; ?>
            <?php if ($ikastaroak->isEmpty()): ?><p>Oraindik ez dago ikastarorik.</p><?php endif; ?>
        </section>
    </main>
</body>
</html>
