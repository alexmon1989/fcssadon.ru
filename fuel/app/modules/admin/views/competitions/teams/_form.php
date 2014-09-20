<?php echo Form::open(array("class"=>"form-horizontal", 'enctype' => 'multipart/form-data')); ?>

	<fieldset>
                <?php if (isset($team)): ?>
		<div class="form-group">
                        <?php if ($team->logo_uri): ?>
			<?php echo Asset::img('teams/'.$team->logo_uri, array('title' => str_replace('"', '', $team->value), 'alt' => str_replace('"', '', $team->value))); ?>
                        <?php else: ?>                    
			<?php echo Asset::img('teams/no.png', array('title' => str_replace('"', '', $team->value), 'alt' => str_replace('"', '', $team->value))); ?>
                        <?php endif; ?>
		</div>
                <?php endif; ?>
            
		<div class="form-group">
			<?php echo Form::label('Название', 'value', array('class'=>'control-label')); ?>
			<?php echo Form::input('value', Input::post('value', isset($team) ? $team->value : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Название')); ?>
		</div>

                <div class="form-group">
			<?php echo Form::label('Логотип (50px*50px)', 'userfile', array('class'=>'control-label')); ?>
                        <?php echo Form::file('userfile', array('class' => 'form-control', 'placeholder'=>'Изображение', 'style'=>'border:none;box-shadow:none')); ?>
		</div>
		
                <div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Сохранить', array('class' => 'btn btn-primary')); ?>		
                </div>
	</fieldset>
<?php echo Form::close(); ?>