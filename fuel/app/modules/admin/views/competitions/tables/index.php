<h2>Список таблиц</h2>
<br>

<p>
	<?php echo Html::anchor('admin/competitions/tables/create', 'Добавить', array('class' => 'btn btn-success')); ?>
</p>

<?php if ($tables): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Название сезона (соревнования)</th>
			<th>Создано</th>
			<th>На главной</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($tables as $item): ?>		<tr>

			<td><?php echo $item->season->value; ?></td>
			<td><?php echo Date::forge($item->created_at)->format("%d.%m.%Y"); ?></td>
			<td><?php echo $item->show_on_main == 0 
                                ? '<a href="#" title="Поставить на главную" onclick="setTableOnMain('.$item->id.', true); return false;"><span class="glyphicon glyphicon-minus"></span></a>' 
                                : '<a href="#" title="Убрать с главной"  onclick="setTableOnMain('.$item->id.', false); return false;"><span class="glyphicon glyphicon-plus"></span></a>'; ?></td>
			<td>
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <?php echo Html::anchor('admin/competitions/tables/edit/'.$item->id, '<i class="glyphicon glyphicon-edit"></i> Редактировать', array('class' => 'btn btn-sm btn-primary')); ?>
                                </div>
                            </div>
			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>Таблицы отсутствуют.</p>

<?php endif; ?>