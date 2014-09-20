<h2>Редактирование пользователя</h2>

<div class="alert alert-info alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Информация!</strong> При редактировании данных пользователя вы можете не указывать его пароль, если хотите оставить его прежним.
</div>

<?php echo render('users/_form'); ?>
<p>	
	<?php echo Html::anchor('admin/users', 'Назад'); ?></p>