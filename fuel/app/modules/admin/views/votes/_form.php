<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
            <div class="form-group">
                <?php echo Form::label('Вопрос', 'question', array('class'=>'control-label')); ?>
                <?php echo Form::input('question', Input::post('question', $vote->question), array('class' => 'col-md-4 form-control', 'placeholder'=>'Вопрос')); ?>
            </div>

            
            <div class="form-group">
                <?php echo Form::label('Ответы', 'answer_1', array('class'=>'control-label')); ?>
                <?php for ($i=1; $i<=10; $i++): ?>
                <div id="div-answer-<?php echo $i ?>">
                    <?php echo Form::input('answer_'.$i, Input::post('answer_'.$i, $vote->answers[$i-1]->answer), array('class' => 'col-md-4 form-control', 'placeholder'=>$i)); ?>
                    <span class="help-block">Проголосовало: <?php echo isset($vote) ? $vote->answers[$i-1]->count : 0 ?></span>
                </div>
                <?php endfor; ?>
            </div>           
            
            <div class="form-group">
                <div class="checkbox">
                    <label>
                      <?php echo Form::checkbox('enable', 1, Input::post('enable', isset($vote) ? $vote->enable : 1) == 1); ?> Включить
                    </label>
                </div>
            </div>
            
            <div class="form-group">
                <div class="checkbox">
                    <label>
                      <?php echo Form::checkbox('reset', 1, Input::post('reset', 0)); ?> Сбросить результаты
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class='control-label'>&nbsp;</label>
                <?php echo Form::submit('submit', 'Сохранить', array('class' => 'btn btn-primary')); ?>		
            </div>
	</fieldset>
<?php echo Form::close(); ?>