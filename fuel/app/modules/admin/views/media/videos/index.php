<h2>Список видеозаписей</h2>
<br>

<p>
    <?php echo Html::anchor('admin/media/videos/create', 'Создать', array('class' => 'btn btn-success')); ?>
</p>

<?php if ($videos): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>ID Видео на Youtube</th>
			<th>Название</th>
			<th>Создано</th>
			<th width="20%">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($videos as $item): ?>		<tr>

                        <td><?php echo $item->videoid; echo ' '.Html::anchor('https://www.youtube.com/watch?v='.$item->videoid, 'Просмотр', array('target' => '_blank')); ?></td>
			<td><?php echo $item->title; ?></td>
			<td><?php echo Date::forge($item->created_at)->format("%d.%m.%Y %H:%M"); ?></td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group">
                                            <?php echo Html::anchor('admin/media/videos/edit/'.$item->id, '<i class="glyphicon glyphicon-edit"></i> Редактировать', array('class' => 'btn btn-sm btn-primary')); ?>						
                                            <?php echo Html::anchor('admin/media/videos/delete/'.$item->id, '<i class="glyphicon glyphicon-trash"></i> Удалить', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Вы уверены?')")); ?>					
                                        </div>
				</div>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>
<center><?php echo $pagination; ?></center>
<?php else: ?>
<p>Видеозаписи отсутствуют.</p>

<?php endif; ?>