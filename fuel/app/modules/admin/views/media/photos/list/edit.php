<h2>Редактирование фотографии</h2>
<br>

<?php echo Asset::img('gallery/' . $photo->image_path, array('height' => 350)); ?>

<br>
<br>

<?php echo render('media/photos/list/_form'); ?>


<p><?php echo Html::anchor('admin/media/photos/list/index/'.$photo->category->id, 'Назад'); ?></p>