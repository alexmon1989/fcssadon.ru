<h2>Редактирование галереи</h2>
<br>

<?php echo render('media/photos/categories/_form'); ?>
<p>
	<?php echo Html::anchor('admin/media/photos/list/index/'.$category->id, 'Просмотр фото'); ?> |
	<?php echo Html::anchor('admin/media/photos/categories', 'Назад'); ?></p>
