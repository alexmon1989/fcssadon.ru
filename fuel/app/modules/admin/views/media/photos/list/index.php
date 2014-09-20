<h2>Список фотографий</h2>
<br>
<p>
    <?php echo Html::anchor('admin/media/photos/categories', '<span class="glyphicon glyphicon-arrow-left"></span> Назад к списку галерей'); ?>
</p>
<p>
    <?php echo Html::anchor('admin/media/photos/list/create/'.$category->id, 'Создать', array('class' => 'btn btn-success')); ?>
</p>

<?php if ($photos): ?>

<center><?php echo $pagination; ?></center>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Изображение</th>
			<th>Создано</th>
			<th width="20%">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($photos as $item): ?>		<tr>

			<td><?php echo Asset::img('gallery/thumbnails/' . $item->image_path, array('height' => 150)); ?></td>
			<td><?php echo Date::forge($item->created_at)->format("%d.%m.%Y %H:%M"); ?></td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group">
                                            <?php echo Html::anchor('admin/media/photos/list/edit/'.$item->id, '<i class="glyphicon glyphicon-edit"></i> Редактировать', array('class' => 'btn btn-sm btn-primary')); ?>						
                                            <?php echo Html::anchor('admin/media/photos/list/delete/'.$item->id, '<i class="glyphicon glyphicon-trash"></i> Удалить', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Вы уверены?')")); ?>					
                                        </div>
				</div>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<center><?php echo $pagination; ?></center>

<?php else: ?>
<p>Фотографии отсутствуют.</p>

<?php endif; ?>