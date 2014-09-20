<h2>Список игроков</h2>
<br>

<p>
    <?php echo Html::anchor('admin/players/create', 'Создать', array('class' => 'btn btn-success')); ?>
</p>

<?php foreach ($players as $value): ?>
    <h4><?php echo $value->value; ?>:</h4>
    <?php if ($value->players): ?>
        <table class="table table-striped">
                <thead>
                        <tr>
                                <th>Имя</th>
                                <th width="20%">Дата рождения</th>
                                <th width="20%">Добавлен</th>
                                <th width="20%">&nbsp;</th>
                        </tr>
                </thead>
                <tbody>
        <?php foreach ($value->players as $item): ?>		
                        <tr>
                            <td><?php echo $item->player_name; ?></td>
                            <td><?php echo !is_null($item->birthdate) ? Date::forge($item->birthdate)->format("%d.%m.%Y") : 'Не указано'; ?></td>
                            <td><?php echo Date::forge($item->created_at)->format("%d.%m.%Y %H:%M"); ?></td>
                            <td>
                                <div class="btn-toolbar">
                                    <div class="btn-group">
                                        <?php echo Html::anchor('admin/players/edit/'.$item->id, '<i class="glyphicon glyphicon-edit"></i> Редактировать', array('class' => 'btn btn-sm btn-primary')); ?>
                                        <?php echo Html::anchor('admin/players/delete/'.$item->id, '<i class="glyphicon glyphicon-trash"></i> Удалить', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Вы уверены?')")); ?>
                                    </div>
                                </div>    
                            </td>
                        </tr>
        <?php endforeach; ?>	
                </tbody>
        </table>

    <?php else: ?>
        <p><?php echo $value->value; ?> отсутствуют.</p>
    <?php endif; ?>
<?php endforeach; ?>