<h2>Список пользователей</h2>

<br>
<?php if ($users): ?>
<table class="table table-striped">
	<thead>
		<tr>
                    <th>Логин</th>
                    <th>E-Mail</th>
                    <th width="20%">&nbsp;</th>
		</tr>
	</thead>
	<tbody>  
            <?php foreach ($users as $key => $item): ?>		
                <tr>
                        <td><?php echo $item->username; ?></td>
                        <td><?php echo $item->email; ?></td>
                        <td>
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <?php echo Html::anchor('admin/users/edit/'.$item->id, '<i class="glyphicon glyphicon-wrench"></i> Редактировать', array('class' => 'btn btn-sm btn-primary')); ?>
                                    <?php echo Html::anchor('admin/users/delete/'.$item->id, '<i class="glyphicon glyphicon-trash"></i> Удалить', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Вы уверены?')")); ?>					
                                </div>
                            </div>

                        </td>
                </tr>
            <?php endforeach; ?>	
        </tbody>
</table>

<?php else: ?>
<p>Пользователи отсутствуют.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/users/create', 'Добавить нового пользователя', array('class' => 'btn btn-success')); ?>

</p>
