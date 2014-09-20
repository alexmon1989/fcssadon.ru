<h2>Редактирование таблицы</h2>
<br>

<p><b>Название сезона (соревнования):</b> <?php echo $table->season->value; ?></p>

<p><b>Результаты:</b></p>

<?php 
    function cmp($a, $b)
    {
        if ($a->place == $b->place) {
            return 0;
        }
        return ($a->place < $b->place) ? -1 : 1;
    }
    $results = json_decode($table->results_json);
    usort($results, "cmp"); ?> 

<table class="table table-striped">
	<thead>
		<tr>
			<th>Место</th>
			<th></th>
			<th>Название</th>
			<th>Игр</th>
			<th>Победы</th>
			<th>Ничьи</th>
			<th>Поражения</th>
			<th>Голы</th>
			<th>Разница голов</th>
			<th>Очки</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
            <?php foreach ($results as $item): ?>
                <tr>
                    <td><?php echo $item->place; ?></td>
                    <td>
                        <?php if ($item->place != 1):  ?>
                            <?php echo HTML::anchor('admin/competitions/tables/decrease_team_position/'.$table->id.'/'.$item->id, '<span class="glyphicon glyphicon-arrow-up"></span>', array('title' => 'Переместить вверх')); ?>
                        <?php endif; ?>
                        <?php if ($item->place != count($results)):  ?>
                            <?php echo HTML::anchor('admin/competitions/tables/increase_team_position/'.$table->id.'/'.$item->id, '<span class="glyphicon glyphicon-arrow-down"></span>', array('title' => 'Переместить вниз')); ?>
                        <?php endif; ?>    
                        
                    </td>
                    <td><?php echo $item->name; ?></td>
                    <td><?php echo $item->games; ?></td>
                    <td><?php echo $item->wins; ?></td>
                    <td><?php echo $item->draws; ?></td>
                    <td><?php echo $item->loss; ?></td>
                    <td><?php echo $item->goals_out . '-' . $item->goals_in; ?></td>
                    <td><?php echo ($item->goals_out - $item->goals_in); ?></td>
                    <td><b><?php echo $item->points; ?></b></td>
                    <td><?php echo Html::anchor('admin/competitions/tables/edit_result/'.$table->id.'/'.$item->id, '<i class="glyphicon glyphicon-edit"></i> Редактировать', array('class' => 'btn btn-sm btn-primary')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
</table>

<p>
	<?php echo Html::anchor('admin/competitions/tables', 'Назад'); ?></p>
