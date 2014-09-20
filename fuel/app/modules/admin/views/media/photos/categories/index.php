<h2>Список фотогалерей</h2>
<br>
<p>
    <?php echo Html::anchor('admin/media/photos/categories/create', 'Создать', array('class' => 'btn btn-success')); ?>
</p>

<?php if ($сategories): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Название</th>
			<th>Количество фото</th>
			<th>Создано</th>
			<th width="35%">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($сategories as $item): ?>		<tr>

			<td><?php echo $item->title; ?></td>
			<td><?php $count = count($item->photos); echo $count != 0 ? Html::anchor('admin/media/photos/list/index/'.$item->id, count($item->photos)) : 0; ?></td>
			<td><?php echo Date::forge($item->created_at)->format("%d.%m.%Y %H:%M"); ?></td>
			<td>
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                        <?php echo Html::anchor('admin/media/photos/list/index/'.$item->id, '<i class="glyphicon glyphicon-eye-open"></i> Просмотр фото', array('class' => 'btn btn-sm btn-success')); ?>						
                                        <?php echo Html::anchor('admin/media/photos/categories/edit/'.$item->id, '<i class="glyphicon glyphicon-edit"></i> Редактировать', array('class' => 'btn btn-sm btn-primary')); ?>						
                                        <?php echo Html::anchor('admin/media/photos/categories/delete/'.$item->id, '<i class="glyphicon glyphicon-trash"></i> Удалить', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Вы уверены?')")); ?>					
                                </div>
                            </div>
			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>
<center><?php echo $pagination; ?></center>
<?php else: ?>
<p>Галереи отсутствуют.</p>

<?php endif; ?>

