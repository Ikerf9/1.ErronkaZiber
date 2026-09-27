<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Erregistratu | Ikastetxea</title>
    <link rel="stylesheet" href="<?= e(asset('css/administrazioa.css')) ?>">
</head>
<body class="login-page">
<main class="login-card">
    <a class="brand" href="<?= e(route('home')) ?>">IKASTETXEA</a>
    <h1>Erregistratu</h1>
    <p class="subtitle">Administratzaileak aurrez ikasle gisa gehitu bazaitu, erabili emandako emaila zure kontua aktibatzeko.</p>
    <?php if ($errors->any()): ?>
        <div class="error" role="alert"><?php foreach ($errors->all() as $error): ?><p><?= e($error) ?></p><?php endforeach; ?></div>
    <?php endif; ?>
    <form method="post" action="<?= e(route('register.submit')) ?>">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <label for="emaila">Helbide elektronikoa</label>
        <input id="emaila" type="email" name="emaila" value="<?= e(old('emaila')) ?>" autocomplete="username" maxlength="255" required>
        <label for="pasahitza">Pasahitza</label>
        <input id="pasahitza" type="password" name="pasahitza" minlength="8" maxlength="255" autocomplete="new-password" aria-describedby="password-help" required>
        <p id="password-help" class="subtitle">Gutxienez 8 karaktere.</p>
        <label for="confirmation">Errepikatu pasahitza</label>
        <input id="confirmation" type="password" name="pasahitza_confirmation" minlength="8" maxlength="255" autocomplete="new-password" required>
        <button type="submit">Kontua aktibatu</button>
    </form>
    <p class="access-note">Baduzu kontua? <a href="<?= e(route('login')) ?>">Saioa hasi</a></p>
    <p class="access-note"><a href="<?= e(route('home')) ?>">Ikastaroetara itzuli</a></p>
</main>
</body>
</html>
