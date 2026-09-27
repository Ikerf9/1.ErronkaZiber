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
        <a class="brand" href="<?= e(route('nagusia')) ?>">ADMINISTRAZIOA</a>
        <div class="account">
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
        <section class="table-card" aria-label="Erabiltzaileen zerrenda">
            <div class="table-heading"><h2>Erabiltzaile guztiak</h2><span class="count"><?= e($erabiltzaileak->count()) ?> erabiltzaile</span></div>
            <div class="table-scroll" tabindex="0" role="region" aria-label="Erabiltzaileen taula">
                <table>
                    <thead><tr><th scope="col">IDa</th><th scope="col">Izena</th><th scope="col">Abizenak</th><th scope="col">Helbide elektronikoa</th><th scope="col">Rolaren IDa</th><th scope="col">Rola</th><th scope="col">Egoera</th></tr></thead>
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
    </main>
</body>
</html>
