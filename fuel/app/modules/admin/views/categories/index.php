<h2>Список категорий статей</h2>

<br>
<?php echo Html::anchor('admin/articles/categories/create', 'Добавить новую категорию', array('class' => 'btn btn-success')); ?>
<br><br>

<?php if (count($categories) > 0): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
            <th>Название</th>
            <th>Количество статей</th>
            <th width="20%"></th>
		</tr>
	</thead>
	<tbody>     
<?php $i = 1; ?>        
<?php foreach ($categories as $key => $item): ?>		
        <tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $item->value; ?></td>
			<td><?php echo count($item->articles); ?></td>
			<td>
                            <div class="btn-toolbar">
                                    <div class="btn-group">
                                        <?php echo Html::anchor('admin/articles/categories/edit/'.$item->id, '<i class="glyphicon glyphicon-edit"></i> Редактировать', array('class' => 'btn btn-sm btn-primary')); ?>						
                                        <?php echo Html::anchor('admin/articles/categories/delete/'.$item->id, '<i class="glyphicon glyphicon-trash"></i> Удалить', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Вы уверены?')")); ?>					
                                    </div>
                            </div>
			</td>
		</tr>      
<?php $i++; ?>          
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>Категории отсутствуют.</p>

<?php endif; ?>