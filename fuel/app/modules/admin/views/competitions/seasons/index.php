<h2>Список сезонов (соревнований)</h2>
<br>
<p>
    <?php echo Html::anchor('admin/competitions/seasons/create', 'Добавить', array('class' => 'btn btn-success')); ?>
</p>
<?php if ($seasons): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Название</th>
			<th>Создан</th>
			<th width="20%">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($seasons as $item): ?>		<tr>

			<td><?php echo $item->value; ?></td>
			<td><?php echo Date::forge($item->created_at)->format("%d.%m.%Y"); ?></td>
			<td>
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <?php echo Html::anchor('admin/competitions/seasons/edit/'.$item->id, '<i class="glyphicon glyphicon-edit"></i> Редактировать', array('class' => 'btn btn-sm btn-primary')); ?>
                                    <?php echo Html::anchor('admin/competitions/seasons/delete/'.$item->id, '<i class="glyphicon glyphicon-trash"></i> Удалить', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Вы уверены?')")); ?>
                                </div>
                            </div>    
			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>
<center><?php echo $pagination; ?></center>

<?php else: ?>
<p>Сезоны отсутствуют.</p>

<?php endif; ?>
