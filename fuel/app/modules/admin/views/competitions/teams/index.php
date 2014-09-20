<h2>Список команд</h2>
<br>
<p>
	<?php echo Html::anchor('admin/competitions/teams/create', 'Создать', array('class' => 'btn btn-success')); ?>
</p>

<?php if ($teams): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Название</th>
			<th>Логотип</th>
			<th>Созадано</th>
			<th width="20%">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($teams as $item): ?>		<tr>

			<td><?php echo $item->value; ?></td>
                        <td><?php echo is_null($item->logo_uri) ? Asset::img('teams/no.png') : Asset::img('teams/'.$item->logo_uri); ?></td>
                        <td><?php echo Date::forge($item->created_at)->format("%d.%m.%Y"); ?></td>
			<td>
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <?php echo Html::anchor('admin/competitions/teams/edit/'.$item->id, '<i class="glyphicon glyphicon-edit"></i> Редактировать', array('class' => 'btn btn-sm btn-primary')); ?>
                                    <?php echo Html::anchor('admin/competitions/teams/delete/'.$item->id, '<i class="glyphicon glyphicon-trash"></i> Удалить', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Вы уверены?')")); ?>
                                </div>
                            </div>    
			</td>
		</tr>
<?php endforeach; ?>	
        </tbody>
</table>

<?php else: ?>
<p>Команды отсутствуют.</p>

<?php endif; ?>