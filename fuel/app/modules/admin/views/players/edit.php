<h2>Редактирование игрока</h2>
<br>

<?php if ($player->image_uri): ?>
    <?php echo Asset::img('players/'.$player->image_uri) ?>
<?php endif; ?>

<?php echo render('players/_form'); ?>
<p>
    <?php echo Html::anchor('admin/players', 'Назад'); ?></p>
