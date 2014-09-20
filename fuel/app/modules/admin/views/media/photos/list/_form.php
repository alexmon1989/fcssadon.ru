<?php echo Form::open(array("class"=>"form-horizontal", 'enctype' => 'multipart/form-data')); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('Фотография', 'userfile', array('class'=>'control-label')); ?>
			<?php echo Form::file('userfile', array('class' => 'col-md-4 form-control', 'placeholder'=>'Фотография', 'style' => 'border:none;box-shadow:none')); ?>
		</div>
            
		<div class="form-group">
                    <label class='control-label'>&nbsp;</label>
                    <?php echo Form::submit('submit', 'Сохранить', array('class' => 'btn btn-primary')); ?>		
                </div>
	</fieldset>
<?php echo Form::close(); ?>