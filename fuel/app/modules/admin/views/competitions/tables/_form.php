<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
            
		<div class="form-group">
			<?php echo Form::label('Игр', 'games', array('class'=>'control-label')); ?>
                        <?php echo Form::input('games', Input::post('games', $data->games), array('class' => 'col-md-8 form-control', 'placeholder'=>'Игр')); ?>
		</div>
            
                <div class="form-group">
			<?php echo Form::label('Побед', 'wins', array('class'=>'control-label')); ?>
                        <?php echo Form::input('wins', Input::post('wins', $data->wins), array('class' => 'col-md-8 form-control', 'placeholder'=>'Побед')); ?>
		</div>
            
                <div class="form-group">
			<?php echo Form::label('Ничьих', 'games', array('class'=>'control-label')); ?>
                        <?php echo Form::input('draws', Input::post('draws', $data->draws), array('class' => 'col-md-8 form-control', 'placeholder'=>'Ничьих')); ?>
		</div>
            
                <div class="form-group">
			<?php echo Form::label('Поражений', 'loss', array('class'=>'control-label')); ?>
                        <?php echo Form::input('loss', Input::post('loss', $data->loss), array('class' => 'col-md-8 form-control', 'placeholder'=>'Поражений')); ?>
		</div>
            
                <div class="form-group">
			<?php echo Form::label('Количесвто забитых голов', 'goals_out', array('class'=>'control-label')); ?>
                        <?php echo Form::input('goals_out', Input::post('goals_out', $data->goals_out), array('class' => 'col-md-8 form-control', 'placeholder'=>'Количесвто забитых голов')); ?>
		</div>
            
                <div class="form-group">
			<?php echo Form::label('Количесвто пропущенных голов', 'goals_in', array('class'=>'control-label')); ?>
                        <?php echo Form::input('goals_in', Input::post('goals_in', $data->goals_in), array('class' => 'col-md-8 form-control', 'placeholder'=>'Количесвто пропущенных голов')); ?>
		</div>
            
                <div class="form-group">
			<?php echo Form::label('Очков', 'points', array('class'=>'control-label')); ?>
                        <?php echo Form::input('points', Input::post('points', $data->points), array('class' => 'col-md-8 form-control', 'placeholder'=>'Игр')); ?>
		</div>
            
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Сохранить', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>