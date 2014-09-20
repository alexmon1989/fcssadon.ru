<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
                <div class="form-group">
			<?php echo Form::label('Сезон (соревнование)', 'season_id', array('class'=>'control-label')); ?>
                        <?php echo Form::select('season_id', Input::post('season_id', ''), $seasons, array('class' => 'col-md-4 form-control', 'placeholder'=>'Сезон (соревнование)')); ?>
		</div>
            
		<div class="form-group">
			<?php echo Form::label('Команда 1', 'team_1_id', array('class'=>'control-label')); ?>
                        <?php echo Form::select('team_1_id', Input::post('team_1_id', ''), array(), array('class' => 'col-md-4 form-control', 'placeholder'=>'Команда 1')); ?>
                </div>
            
		<div class="form-group">
			<?php echo Form::label('Команда 2', 'team_2_id', array('class'=>'control-label')); ?>
                        <?php echo Form::select('team_2_id', Input::post('team_2_id', ''), array(), array('class' => 'col-md-4 form-control', 'placeholder'=>'Команда 2')); ?>
		</div>
            
                <div class="form-group">
			<?php echo Form::label('Дата', 'date', array('class'=>'control-label')); ?>
                        <?php echo Form::input('date', Input::post('date', ''), array('class' => 'col-md-4 form-control datepicker', 'placeholder'=>'Дата')); ?>
		</div>
            
		<div class="form-group">
			<?php echo Form::label('Название матча', 'name', array('class'=>'control-label')); ?>
			<?php echo Form::input('name', Input::post('name', ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Название матча')); ?>
                        <p class="help-block">Например, "Тур 1".</p>
		</div>
            
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Сохранить', array('class' => 'btn btn-primary')); ?>		
                </div>
	</fieldset>

<?php echo Form::close(); ?>

<script>
    $(document).ready(function() {
        
        getTeams($("#form_season_id").val());
        
        $("#form_season_id").change(function() {
            getTeams($("#form_season_id").val());
        });
        
        $('.datepicker').datepicker({format: 'dd.mm.yyyy', weekStart: 1});
    } );  
    
</script>