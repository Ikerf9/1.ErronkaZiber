<?php
$socialLinks = array_filter(config('ikastetxea.socials', []), fn ($url) =>
    is_string($url) && filter_var($url, FILTER_VALIDATE_URL)
    && in_array(strtolower(parse_url($url, PHP_URL_SCHEME) ?? ''), ['https', 'http'], true));
?>
<footer class="site-footer">
    <div class="footer-grid">
        <div>
            <a class="footer-brand" href="<?= e(route('home')) ?>"><?= e(config('ikastetxea.name')) ?></a>
            <p>Ikasi. Garatu. Aurrera egin.</p>
        </div>
        <div>
            <h2>Helbidea</h2>
            <?php if (config('ikastetxea.address')): ?>
                <address><?= nl2br(e(config('ikastetxea.address'))) ?></address>
            <?php else: ?>
                <p>Helbidea laster egongo da eskuragarri.</p>
            <?php endif; ?>
            <?php if (filter_var(config('ikastetxea.email'), FILTER_VALIDATE_EMAIL)): ?>
                <p><a href="mailto:<?= e(config('ikastetxea.email')) ?>"><?= e(config('ikastetxea.email')) ?></a></p>
            <?php endif; ?>
        </div>
        <div>
            <h2>Sare sozialak</h2>
            <?php if ($socialLinks): ?>
                <nav class="footer-socials" aria-label="Sare sozialak">
                    <?php foreach ($socialLinks as $name => $url): ?>
                        <a href="<?= e($url) ?>"><?= e($name) ?> <span aria-hidden="true">&nearr;</span></a>
                    <?php endforeach; ?>
                </nav>
            <?php else: ?>
                <p>Gure sare sozialen estekak laster.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php if (config('ikastetxea.demo_contact')): ?><p class="footer-demo">Helbidea, emaila eta sare sozialak adibidezko datuak dira.</p><?php endif; ?>
    <div class="footer-bottom"><small>&copy; <?= e(date('Y')) ?> <?= e(config('ikastetxea.name')) ?>. Eskubide guztiak erreserbatuta.</small><a href="<?= e(route('home')) ?>">Ikastaroak</a></div>
</footer>
