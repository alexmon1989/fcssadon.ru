<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('Название', 'title', array('class'=>'control-label')); ?>

				<?php echo Form::input('title', Input::post('title', isset($category) ? $category->title : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Название')); ?>

		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Сохранить', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>