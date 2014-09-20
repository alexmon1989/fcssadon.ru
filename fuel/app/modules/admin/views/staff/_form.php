<?php echo Form::open(array("class"=>"form-horizontal", 'enctype' => 'multipart/form-data')); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('Имя (фамилия, имя)', 'staff_name', array('class'=>'control-label')); ?>
                        <?php echo Form::input('staff_name', Input::post('staff_name', isset($staff) ? $staff->staff_name : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Имя (фамилия, имя)')); ?>
		</div>
            
		<div class="form-group">
			<?php echo Form::label('Дата рождения', 'birthdate', array('class'=>'control-label')); ?>
                        <?php echo Form::input('birthdate', Input::post('birthdate', isset($staff) ? Date::forge($staff->birthdate)->format("%d.%m.%Y") : ''), array('class' => 'col-md-4 form-control datepicker', 'placeholder'=>'Дата рождения')); ?>
		</div>
            
		<div class="form-group">
			<?php echo Form::label('Данные', 'data', array('class'=>'control-label')); ?>
                        <?php echo Form::textarea('data', Input::post('data', isset($staff) ? $staff->data : ''), array('class' => 'col-md-8 form-control textarea_tinymce', 'rows' => 8, 'placeholder'=>'Данные об игроке')); ?>

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