<?php echo Form::open(array("class"=>"form-horizontal")); ?>

<div class="row">
    <div class="col-md-4">
        <fieldset>		
            <div class="form-group">
                <?php echo Form::label('Название', 'value', array('class'=>'control-label')); ?>

                    <?php echo Form::input('value', Input::post('value', isset($category) ? $category->value : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Название')); ?>

            </div>

            <div class="form-group">
                <label class='control-label'>&nbsp;</label>
                <?php echo Form::submit('submit', 'Сохранить', array('class' => 'btn btn-primary')); ?>		</div>
        </fieldset>
    </div>    
</div>
<?php echo Form::close(); ?>