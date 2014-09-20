<h2>Список видео</h2>
<br>

<p>
    <?php echo Html::anchor('admin/videos/create', 'Добавить', array('class' => 'btn btn-success')); ?>
</p>

<?php if ($videos): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>ID видео на Youtube</th>
			<th>Создано</th>
			<th width="20%">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($videos as $item): ?>		
            <tr>
        	<td><?php echo $item->videoid; echo ' '.Html::anchor('https://www.youtube.com/watch?v='.$item->videoid, 'Просмотр', array('target' => '_blank')); ?></td>
		<td><?php echo Date::forge($item->created_at)->format("%d.%m.%Y %H:%M"); ?></td>
		<td>
                	<div class="btn-toolbar">
                            <div class="btn-group">
                                <?php echo Html::anchor('admin/videos/edit/'.$item->id, '<i class="glyphicon glyphicon-wrench"></i> Редактировать', array('class' => 'btn btn-sm btn-primary')); ?>
                                <?php echo Html::anchor('admin/videos/delete/'.$item->id, '<i class="glyphicon glyphicon-trash"></i> Удалить', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Вы уверены?')")); ?>
                            </div>
			</div>
		</td>
            </tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>Видео отсутствуют.</p>

<?php endif; ?>