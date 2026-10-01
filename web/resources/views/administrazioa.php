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
        <section class="page-hero admin-hero" aria-labelledby="page-title">
            <div class="hero-copy">
                <span class="eyebrow">KUDEAKETA GUNEA</span>
                <h1 id="page-title">Erabiltzaileak</h1>
                <p class="subtitle">Sisteman erregistratutako erabiltzaile guztien zerrenda.</p>
                <a class="button-link hero-button" href="#ikasle-berria"><span aria-hidden="true">+</span> Ikaslea gehitu</a>
            </div>
            <dl class="hero-summary admin-summary">
                <div><dt>Erabiltzaileak</dt><dd><?= e($erabiltzaileak->count()) ?></dd></div>
                <div><dt>Ikastaroak</dt><dd><?= e($ikastaroak->count()) ?></dd></div>
            </dl>
        </section>
        <?php if (session('status')): ?><p class="success" role="status"><?= e(session('status')) ?></p><?php endif; ?>
        <?php if ($errors->any()): ?>
            <div class="error" role="alert"><?php foreach ($errors->all() as $error): ?><p><?= e($error) ?></p><?php endforeach; ?></div>
        <?php endif; ?>
        <section class="admin-statistics" aria-labelledby="stats-title">
            <div class="statistics-heading"><h2 id="stats-title">Estatistikak</h2><span>Uneko datuak</span></div>
            <dl class="stats-grid">
                <div class="stat-card"><dt>Ikasleak guztira</dt><dd><?= e($stats['students']) ?></dd><p>Administratzaileak kontatu gabe</p></div>
                <div class="stat-card"><dt>Ikasle aktiboak</dt><dd><?= e($stats['active_students']) ?></dd><p><?= e($stats['inactive_students']) ?> ikasle ez aktibo</p></div>
                <div class="stat-card"><dt>Matrikula aktiboak</dt><dd><?= e($stats['enrollments']) ?></dd><p>Ikastaro guztietan</p></div>
                <div class="stat-card"><dt>Plaza libreak</dt><dd><?= e($stats['available']) ?></dd><p><?= e($stats['capacity']) ?> plaza guztira</p></div>
            </dl>
            <div class="occupancy-card">
                <h3>Ikastaroen okupazioa</h3>
                <p class="subtitle">Matrikula aktiboak eta ikastaro bakoitzeko edukiera.</p>
                <?php foreach ($courseStats as $courseIndex => $courseStat): ?>
                    <div class="occupancy-row">
                        <div class="occupancy-label"><label for="occupancy-<?= e($courseIndex) ?>"><?= e($courseStat['title']) ?></label><span><?= e($courseStat['enrolled']) ?> / <?= e($courseStat['capacity']) ?> &middot; <?= $courseStat['capacity'] > 0 ? e($courseStat['percent']).'%' : 'Edukierarik gabe' ?></span></div>
                        <progress id="occupancy-<?= e($courseIndex) ?>" value="<?= e(min(100, $courseStat['percent'])) ?>" max="100"><?= e($courseStat['percent']) ?>%</progress>
                    </div>
                <?php endforeach; ?>
                <?php if ($courseStats->isEmpty()): ?><p class="empty">Oraindik ez dago ikastarorik.</p><?php endif; ?>
            </div>
        </section>
        <section class="student-panel" id="ikasle-berria">
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
        <section class="table-card<?= session('created_student_id') ? ' table-refreshed' : '' ?>" aria-label="Erabiltzaileen zerrenda">
            <div class="table-heading"><h2>Erabiltzaile guztiak</h2><span class="count"><?= e($erabiltzaileak->count()) ?> erabiltzaile</span></div>
            <div class="table-scroll users-table-scroll" tabindex="0" role="region" aria-label="Erabiltzaileen taula">
                <table>
                    <thead>
<tr>
    <th scope="col">IDa</th>
    <th scope="col">Izena</th>
    <th scope="col">Abizenak</th>
    <th scope="col">Helbide elektronikoa</th>
    <th scope="col">Rolaren IDa</th>
    <th scope="col">Rola</th>
    <th scope="col">Kontuaren egoera</th>
    <th scope="col" class="actions-column">Ezabatu</th>
</tr>
</thead>
                    <tbody>
                    <?php foreach ($erabiltzaileak as $erabiltzailea): ?>
    <tr<?= (string) session('created_student_id') === (string) $erabiltzailea->id_erabiltzailea ? ' class="student-created"' : '' ?>>
        <td><?= e($erabiltzailea->id_erabiltzailea) ?></td>
        <td><?= e($erabiltzailea->izena) ?></td>
        <td><?= e($erabiltzailea->abizenak) ?></td>
        <td><?= e($erabiltzailea->emaila) ?></td>
        <td><?= e($erabiltzailea->id_rola) ?></td>
        <td><?= e($erabiltzailea->rola?->rola_izena ?? 'Rolik gabe') ?></td>
        <td>
            <span class="badge <?= $erabiltzailea->aktibo ? 'active' : 'inactive' ?>">
                <?= $erabiltzailea->aktibo ? 'Aktibo' : 'Ez aktibo' ?>
            </span>
        </td>

        <td class="delete-cell">
            <?php if (auth()->id() !== $erabiltzailea->id_erabiltzailea): ?>

                <form
                    method="post"
                    action="<?= e(route('users.destroy', $erabiltzailea)) ?>"
                    onsubmit="return confirm('Ziur zaude erabiltzaile hau ezabatu nahi duzula?');"
                >
                    <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="_method" value="DELETE">

                    <button
                        type="submit"
                        class="delete-button"
                        title="Erabiltzailea ezabatu"
                        aria-label="<?= e($erabiltzailea->izena) ?> ezabatu"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M3 6h18"></path>
                            <path d="M8 6V4h8v2"></path>
                            <path d="M19 6l-1 14H6L5 6"></path>
                            <path d="M10 11v5"></path>
                            <path d="M14 11v5"></path>
                        </svg>
                    </button>
                </form>

            <?php else: ?>

                <button
                    type="button"
                    class="delete-button disabled"
                    title="Ezin duzu zure kontua ezabatu"
                    disabled
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M3 6h18"></path>
                        <path d="M8 6V4h8v2"></path>
                        <path d="M19 6l-1 14H6L5 6"></path>
                        <path d="M10 11v5"></path>
                        <path d="M14 11v5"></path>
                    </svg>
                </button>

            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>
                    <?php if ($erabiltzaileak->isEmpty()): ?>
                        <tr><td colspan="8" class="empty">Ez dago erabiltzaile erregistraturik.</td></tr>
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
