<div class="course-admin-actions">
    <a class="button-link secondary" href="<?= e(route('courses.edit', $ikastaroa)) ?>">Editatu</a>
    <form method="post" action="<?= e(route('courses.destroy', $ikastaroa)) ?>" onsubmit="return confirm('Ikastaroa eta bere matrikula guztiak ezabatuko dira. Jarraitu nahi duzu?');">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <button class="course-delete" type="submit" aria-label="<?= e($ikastaroa->izenburua) ?> ezabatu">Ezabatu</button>
    </form>
</div>
