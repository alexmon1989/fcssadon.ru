<h2>Список статей</h2>
<br>
<?php echo Html::anchor('admin/articles/create', 'Добавить новую статью', array('class' => 'btn btn-success')); ?>
<br><br>

<?php echo Html::anchor('#', '<span id="span-show-filters" class="glyphicon glyphicon-arrow-down"></span> <b>Фильтры</b>', array('onclick' => '$(\'#form-filters\').toggle(\'medium\'); return false;')); ?>
<br><br>
<div class="row " id="form-filters" <?php echo (Session::get('filter_articles_category_id') != null or Session::get('filter_articles_title') != '') ? '' : 'style="display: none"'?>>
    <div class="col-md-4 bg-warning">
        <?php echo Form::open(); ?>
          <div class="form-group">
            <br>
            <?php echo Form::label('Название', 'title'); ?>
            <?php echo Form::input('title', Session::get('filter_articles_title'), array('placeholder' => 'Название', 'class' => 'form-control')); ?>
          </div>
          <div class="form-group">
            <?php echo Form::label('Категория', 'category_id'); ?>
            <?php echo Form::select('category_id', Session::get('filter_articles_category_id'), $categories, array('class' => 'form-control')); ?>
          </div>
          <button type="submit" class="btn btn-primary">Фильтровать</button>
          <br><br>
        <?php echo Form::close(); ?>
    </div>
</div>


<?php if (count($articles) > 0): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
            <th>
                Название&nbsp;
                <a href="#" onclick="sortArticles('title', 'asc'); return false;"><span id="span-show-filters" class="glyphicon glyphicon-arrow-down"></span></a>
                <a href="#" onclick="sortArticles('title', 'desc'); return false;"><span id="span-show-filters" class="glyphicon glyphicon-arrow-up"></span></a>
            </th>
			<th>
                Категория&nbsp;
                <a href="#" onclick="sortArticles('category.value', 'asc'); return false;"><span id="span-show-filters" class="glyphicon glyphicon-arrow-down"></span></a>
                <a href="#" onclick="sortArticles('category.value', 'desc'); return false;"><span id="span-show-filters" class="glyphicon glyphicon-arrow-up"></span></a>
            </th>
            <th width="15%">
                Дата создания&nbsp;
                <a href="#" onclick="sortArticles('created_at', 'asc'); return false;"><span id="span-show-filters" class="glyphicon glyphicon-arrow-down"></span></a>
                <a href="#" onclick="sortArticles('created_at', 'desc'); return false;"><span id="span-show-filters" class="glyphicon glyphicon-arrow-up"></span></a></th>
			<th width="20%"></th>
		</tr>
	</thead>
	<tbody>
<?php $i = 1; ?>        
<?php foreach ($articles as $item): ?>		
        <tr>
			<td><?php echo ($current_page - 1) * $per_page + $i; ?></td>
			<td><?php echo $item->title; ?></td>
			<td><?php echo $item->category->value; ?></td>
			<td><?php echo Date::forge($item->created_at)->format("%d.%m.%Y"); ?></td>
			<td>
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <?php echo Html::anchor('admin/articles/edit/'.$item->id, '<i class="glyphicon glyphicon-edit"></i> Редактировать', array('class' => 'btn btn-sm btn-primary')); ?>
                                    <?php echo Html::anchor('admin/articles/delete/'.$item->id, '<i class="glyphicon glyphicon-trash"></i> Удалить', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Вы уверены?')")); ?>
                                </div>
                            </div>    
			</td>
		</tr>
<?php $i++; ?>            
<?php endforeach; ?>	</tbody>
</table>
<center><?php echo $pagination; ?></center>

<?php else: ?>
<p>Статьи отсутствуют.</p>

<?php endif; ?>