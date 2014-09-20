<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                          <?php echo Form::checkbox('show', 1, Input::post('show', isset($settings) ? $settings->show : NULL)); ?> Включить
                        </label>
                    </div>
		</div>
            
                <div class="form-group">
			<?php echo Form::label('Соревнование', 'season_id', array('class'=>'control-label')); ?>
                        <?php echo Form::select('season_id', Input::post('season_id', isset($settings) ? $settings->season_id : ''), $seasons, array('class' => 'col-md-4 form-control')); ?>
		</div>
            
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Сохранить', array('class' => 'btn btn-primary')); ?>		
                </div>
	</fieldset>
<?php echo Form::close(); ?>