<div class="course-roster">
    <h3>Ikastaroko ikasleak</h3>
    <?php if ($ikastaroa->matrikulak->isEmpty()): ?>
        <p class="subtitle">Oraindik ez dago ikaslerik matrikulatuta.</p>
    <?php else: ?>
        <div class="table-scroll" tabindex="0" role="region" aria-label="<?= e($ikastaroa->izenburua) ?>: ikasleak">
            <table>
                <thead><tr><th scope="col">Ikaslea</th><th scope="col">Emaila</th><th scope="col">Matrikula-data</th><th scope="col">Matrikularen egoera</th><th scope="col">Ekintza</th></tr></thead>
                <tbody>
                <?php foreach ($ikastaroa->matrikulak as $matrikula): ?>
                    <tr>
                        <td><?= e($matrikula->erabiltzailea?->izena) ?> <?= e($matrikula->erabiltzailea?->abizenak) ?></td>
                        <td><?= e($matrikula->erabiltzailea?->emaila) ?></td>
                        <td><?= e($matrikula->matrikula_data) ?></td>
                        <td><span class="badge <?= $matrikula->egoera === 'aktibo' ? 'active' : 'inactive' ?>"><?= $matrikula->egoera === 'aktibo' ? 'Aktibo' : 'Ez aktibo' ?></span></td>
                        <td>
                            <form method="post" action="<?= e(route('enrollments.update', $matrikula)) ?>">
                                <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                                <input type="hidden" name="_method" value="PATCH">
                                <input type="hidden" name="egoera" value="<?= $matrikula->egoera === 'aktibo' ? 'ez_aktibo' : 'aktibo' ?>">
                                <button class="secondary" type="submit" aria-label="<?= e($matrikula->erabiltzailea?->izena.' '.$matrikula->erabiltzailea?->abizenak) ?>: <?= $matrikula->egoera === 'aktibo' ? 'matrikula desaktibatu' : 'matrikula aktibatu' ?>"><?= $matrikula->egoera === 'aktibo' ? 'Desaktibatu' : 'Aktibatu' ?></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
