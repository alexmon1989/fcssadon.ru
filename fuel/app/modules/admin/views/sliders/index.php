<h2>Список <span class='muted'>слайдеров</span></h2>
<br>

<p>
    <?php echo Html::anchor('admin/sliders/create', 'Добавить', array('class' => 'btn btn-success')); ?>
</p>

<?php if ($sliders): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th width="35%">Изображение</th>
			<th width="25%">Ссылка</th>
			<th>Позиция</th>
			<th width="20%">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($sliders as $slider): ?>		
        <tr>
            <td><?php echo Asset::img('slider/' . $slider->img_path, array('width' => 250)); ?></td>
            <td><?php echo Html::anchor(Uri::create($slider->uri), NULL, array('target' => '_blank', 'title' => 'Открыть в новой вкладке')); ?></td>
            <td>
                <?php echo $slider->position; ?> |
                <?php echo Html::anchor('admin/sliders/decrease_pos/'.$slider->id, '<span class="glyphicon glyphicon-arrow-up" title="Поднять"></span>'); ?> |
		<?php echo Html::anchor('admin/sliders/increase_pos/'.$slider->id, '<span class="glyphicon glyphicon-arrow-down" title="Опустить"></span>'); ?>
            </td>
            <td>
                <div class="btn-toolbar">
                    <div class="btn-group">
                        <?php echo Html::anchor('admin/sliders/edit/'.$slider->id, '<i class="glyphicon glyphicon-wrench"></i> Редактировать', array('class' => 'btn btn-sm btn-primary')); ?>
                        <?php echo Html::anchor('admin/sliders/delete/'.$slider->id, '<i class="glyphicon glyphicon-trash"></i> Удалить', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Вы уверены?')")); ?>
                    </div>
                </div>  
            </td>
	</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>Нет данных.</p>

<?php endif; ?>