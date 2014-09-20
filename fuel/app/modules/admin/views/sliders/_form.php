<?php echo Form::open(array("class"=>"form-horizontal", 'enctype' => 'multipart/form-data')); ?>

	<fieldset>
                <div class="form-group">
                        <?php echo Form::label('Выберите изображение (650px * 435px)', 'userfile', array('class'=>'control-label')); ?>
                        <?php echo Form::file('userfile', array('class' => 'form-control', 'placeholder'=>'Изображение', 'style'=>'border:none;box-shadow:none')); ?>
		</div>
            
		<div class="form-group">
			<?php echo Form::label('Ссылка: <b>http://fcssadon.ru/</b>', 'uri', array('class'=>'control-label')); ?>
			<?php echo Form::input('uri', Input::post('uri', isset($slider) ? $slider->uri : ''), array('class' => 'form-control', 'placeholder'=>'Относительная ссылка')); ?>

		</div>
            
		<div class="form-group">
			<?php echo Form::label('Описание', 'description', array('class'=>'control-label')); ?>
			<?php echo Form::input('description', Input::post('description', isset($slider) ? $slider->description : ''), array('class' => 'form-control', 'placeholder'=>'Описание')); ?>

		</div>
            
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Сохранить', array('class' => 'btn btn-primary')); ?>	
		</div>
	</fieldset>

<?php echo Form::close(); ?>