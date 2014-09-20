<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('ID видео на Youtube', 'videoid', array('class'=>'control-label')); ?>

				<?php echo Form::input('videoid', Input::post('videoid', isset($video) ? $video->videoid : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'ID видео на Youtube')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Название', 'title', array('class'=>'control-label')); ?>

				<?php echo Form::input('title', Input::post('title', isset($video) ? $video->title : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Название')); ?>

		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Сохранить', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>