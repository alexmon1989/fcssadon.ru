<?php echo Form::open(array("class"=>"form-horizontal", 'autocomplete' => 'off')); ?>

	<fieldset>
        
                <?php if (!isset($user)): ?>
                <div class="form-group">
			<?php echo Form::label('Логин*', 'username', array('class'=>'control-label')); ?>
                        <?php echo Form::input('username', Input::post('username', isset($user) ? $user->username : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Логин', 'required' => 'required')); ?>
                </div>
                <?php endif; ?>
            
                <div class="form-group">
			<?php echo Form::label('E-Mail*', 'email', array('class'=>'control-label')); ?>
                        <?php echo Form::input('email', Input::post('email', isset($user) ? $user->email : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'E-Mail', 'required' => 'required')); ?>
                </div>     
            
                <div class="form-group">
			<?php echo Form::label('Пароль', 'password', array('class'=>'control-label')); ?>
                        <?php echo Form::password('password', null, array('class' => 'col-md-4 form-control', 'placeholder'=>'Пароль')); ?>
                </div>  
            
                <div class="form-group">
			<?php echo Form::label('Подтверждение пароля', 'password2', array('class'=>'control-label')); ?>
                        <?php echo Form::password('password2', null, array('class' => 'col-md-4 form-control', 'placeholder'=>'Подтверждение пароля')); ?>
                </div> 
        
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Сохранить', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>