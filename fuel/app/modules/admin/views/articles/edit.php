<h2>Редактирование статьи</h2>
<br>

<?php echo render('articles/_form', array('categories' => $categories)); ?>
<p>	
	<?php echo Html::anchor('admin/articles', 'Назад'); ?></p>
