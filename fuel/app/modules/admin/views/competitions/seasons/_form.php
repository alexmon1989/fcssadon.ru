<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('Название', 'value', array('class'=>'control-label')); ?>
                        <?php echo Form::input('value', Input::post('value', isset($season) ? $season->value : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Название')); ?>
		</div>
            
                <div class="form-group">
			<?php echo Form::label('Команды (используйте кнопки ctrl, shift для множественного выбора)', 'teams', array('class'=>'control-label')); ?>
                        <?php echo Form::select('teams[]', Input::post('teams', isset($season) ? $season_teams : ''), $teams, array('class' => 'col-md-4 form-control', 'multiple'=>'multiple')); ?>
		</div>
            
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                          <?php echo Form::checkbox('has_table', 1, Input::post('has_table', isset($season) ? $season->has_table : NULL)); ?> Создать таблицу и делать подсчёт очков
                        </label>
                    </div>
		</div>
            
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Сохранить', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>