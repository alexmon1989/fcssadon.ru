<h2>Редактирование персонала</h2>
<br>

<?php if ($staff->image_uri): ?>
    <?php echo Asset::img('staff/'.$staff->image_uri) ?>
<?php endif; ?>

<?php echo render('staff/_form'); ?>
<p>
    <?php echo Html::anchor('admin/staff', 'Назад'); ?></p>
