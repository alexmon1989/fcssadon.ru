<?php echo Form::open(array("class"=>"form-horizontal", 'enctype' => 'multipart/form-data')); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('Имя (фамилия, имя)', 'player_name', array('class'=>'control-label')); ?>
                        <?php echo Form::input('player_name', Input::post('player_name', isset($player) ? $player->player_name : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Имя ирока')); ?>
		</div>
            
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                          <?php echo Form::checkbox('is_core_player', 1, Input::post('is_core_player', isset($player) ? $player->is_core_player : NULL)); ?> Основной игрок
                        </label>
                    </div>
                    <p class="help-block">Если включено, то игрок попадёт в список основных игроков, а если нет - в список всех игроков.</p>
		</div>
            
		<div class="form-group">
			<?php echo Form::label('Позиция на поле', 'position_id', array('class'=>'control-label')); ?>
                        <?php echo Form::select('position_id', 
                                Input::post('position_id', isset($player) ? $player->position_id : ''), 
                                array(1 => 'Вратарь', 2 => 'Защитник', 3 => 'Полузащитник', 4 => 'Нападающий'),
                                array('class' => 'col-md-4 form-control')); ?>
		</div>
            
		<div class="form-group">
			<?php echo Form::label('Дата рождения', 'birthdate', array('class'=>'control-label')); ?>
                        <?php echo Form::input('birthdate', Input::post('birthdate', isset($player) ? Date::forge($player->birthdate)->format("%d.%m.%Y") : ''), array('class' => 'col-md-4 form-control datepicker', 'placeholder'=>'Дата рождения')); ?>
		</div>
            
		<div class="form-group">
			<?php echo Form::label('Данные об игроке', 'data', array('class'=>'control-label')); ?>
                        <?php echo Form::textarea('data', Input::post('data', isset($player) ? $player->data : ''), array('class' => 'col-md-8 form-control textarea_tinymce', 'rows' => 8, 'placeholder'=>'Данные об игроке')); ?>

		</div>
            
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

<script>
    $(function() {
        $('.datepicker').datepicker({format: 'dd.mm.yyyy', weekStart: 1});
    });    
</script>