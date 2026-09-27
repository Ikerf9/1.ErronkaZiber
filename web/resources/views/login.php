<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Saioa hasi | Ikastetxea</title>
    <link rel="stylesheet" href="<?= e(asset('css/administrazioa.css')) ?>">
</head>
<body class="login-page">
    <main class="login-card">
        <span class="brand">IKASTETXEA</span>
        <div class="login-icon" aria-hidden="true">&#128274;</div>
        <h1>Saioa hasi</h1>
        <p class="subtitle">Ongi etorri. Hasi saioa zure kontuan.</p>
        <?php if (session('status')): ?><p class="success" role="status"><?= e(session('status')) ?></p><?php endif; ?>
        <?php if ($errors->any()): ?>
            <div class="error" role="alert">
                <?php foreach ($errors->all() as $error): ?>
                    <p><?= e($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="<?= e(route('login.submit')) ?>">
            <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
            <label for="emaila">Helbide elektronikoa</label>
            <input id="emaila" name="emaila" type="email" value="<?= e(old('emaila')) ?>" placeholder="zure@emaila.eus" autocomplete="username" maxlength="255" required autofocus>
            <label for="pasahitza">Pasahitza</label>
            <input id="pasahitza" name="pasahitza" type="password" placeholder="Idatzi zure pasahitza" autocomplete="current-password" maxlength="255" required>
            <button type="submit">Saioa hasi <span aria-hidden="true">&rarr;</span></button>
        </form>
        <p class="access-note"><a href="<?= e(route('register')) ?>">Erregistratu</a> &middot; <a href="<?= e(route('home')) ?>">Ikastaroetara itzuli</a></p>
    </main>
</body>
</html>
