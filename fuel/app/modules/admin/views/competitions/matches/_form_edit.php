<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
            
            <div class="form-group">
                <?php echo Form::label('Сезон (соревнование):', NULL, array('class'=>'control-label')); ?>
                <i><?php echo $match->season->value; ?></i>
            </div>

            <div class="form-group">
                <?php echo Form::label('Название матча:', NULL, array('class'=>'control-label')); ?>
                <?php echo Form::input('name', Input::post('name', isset($match) ? $match->name : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Название матча')); ?>
            </div>

            <div class="form-group">
                <?php echo Form::label('Дата:', 'date', array('class'=>'control-label')); ?>
                <?php echo Form::input('date', Input::post('date', (isset($match) and !is_null($match->date)) ? Date::forge($match->date)->format("%d.%m.%Y") : ''), array('class' => 'col-md-4 form-control datepicker', 'placeholder'=>'Дата')); ?>
            </div>  
            
            <div class="form-group">
                <?php echo Form::label('Статус', 'status_id', array('class'=>'control-label')); ?>
                <?php echo Form::select('status_id', Input::post('status_id', isset($match) ? $match->status_id : ''), array(1 => 'Не сыграно', 2 => 'Закончен'), array('class' => 'col-md-4 form-control', 'placeholder'=>'Status id')); ?>
            </div>
            
            <div class="form-group" id="change-table" style="display: none">
                <div class="checkbox">
                    <label>
                        <?php echo Form::checkbox('change_table', 1, Input::post('change_table')); ?> Внести изменения в таблицу очков (если она существует для этого соревнования)
                    </label>
                </div>
                <p class="help-block"><b>Внимание!</b> Если Вы редактируете данный матч не впервые и уже вносили изменения в таблицу, то стоит внести изменения в таблицу вручную или не ставить галочку сюда.</p>
            </div>          
            
            <hr>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
			<?php echo Form::label('Команда 1:', NULL, array('class'=>'control-label')); ?>
                        <i><?php echo $match->team_1->value; ?></i>
                    </div>  
                    
                    <div class="form-group">
			<?php echo Form::label('Голов:', 'team_1_goals', array('class'=>'control-label')); ?>
                        <div class="row">
                            <div class="col-xs-2">
                                <?php echo Form::input('team_1_goals', Input::post('team_1_goals', isset($match) ? (int) $match->team_1_goals : '0'), array('class' => 'col-md-4 form-control', 'placeholder'=>'Голов')); ?>
                            </div>
                        </div>                        
                    </div>
                    
                    <div class="form-group">
			<?php echo Form::label('Состав:', 'team_1_lineup', array('class'=>'control-label')); ?>
                        <div class="row">
                            <div class="col-xs-10">
                                <?php echo Form::textarea('team_1_lineup', Input::post('team_1_lineup', isset($match) ? $match->team_1_lineup : ''), array('class' => 'col-md-8 form-control', 'rows' => 8, 'placeholder'=>'Состав')); ?>
                            </div>
                        </div>  
                    </div>
                    
                    <div class="form-group">
			<?php echo Form::label('События:', NULL, array('class'=>'control-label')); ?>
                        <p id="events_team1">
                            <?php $has_events_1 = FALSE; ?>
                            <?php foreach ($match->matches_events as $item): ?>
                                <?php if ($item->team_id == $match->team_1->id): ?>
                                    <?php $has_events_1 = TRUE; ?>
                                    <?php $item->comment == '' ? $comment = '' : $comment = '('.$item->comment.')'; ?>
                                    <?php echo "<span id='event_{$item->id}'><i>".$item->event->value.'</i> '.$item->time.'" <b>'.$item->player.'</b> '.$comment.' '.Html::anchor('#', '<span class="glyphicon glyphicon-remove"></span>', array('onclick' => "deleteMatchEvent({$item->id},1); return false;", 'title' => 'Удалить')).'</span><br>'; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>     
                            <?php echo $has_events_1 == FALSE ? 'События отсутствуют.' : '' ?>
                        </p>
                        <p>                            
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-events-team1">
                                Добавить событие
                            </a>
                        </p>
                    </div>
                </div>                
                
                <div class="col-md-6">
                    <div class="form-group">
			<?php echo Form::label('Команда 2:', NULL, array('class'=>'control-label')); ?>
                        <i><?php echo $match->team_2->value; ?></i>
                    </div>  
                    
                    <div class="form-group">
			<?php echo Form::label('Голов:', 'team_2_goals', array('class'=>'control-label')); ?>
			<div class="row">
                            <div class="col-xs-2">
                                <?php echo Form::input('team_2_goals', Input::post('team_2_goals', isset($match) ? (int) $match->team_2_goals : '0'), array('class' => 'col-md-4 form-control', 'placeholder'=>'Голов')); ?>
                            </div>
                        </div>     
                    </div>
                    
                     <div class="form-group">
			<?php echo Form::label('Состав:', 'team_2_lineup', array('class'=>'control-label')); ?>
                        <div class="row">
                            <div class="col-xs-10">
                                <?php echo Form::textarea('team_2_lineup', Input::post('team_2_lineup', isset($match) ? $match->team_1_lineup : ''), array('class' => 'col-md-8 form-control', 'rows' => 8, 'placeholder'=>'Состав')); ?>
                            </div>
                        </div>  
                    </div>
                    
                    <div class="form-group">
			<?php echo Form::label('События:', NULL, array('class'=>'control-label')); ?>
                        <p id="events_team2">
                            <?php $has_events_2 = FALSE; ?>
                            <?php foreach ($match->matches_events as $item): ?>
                                <?php if ($item->team_id == $match->team_2->id): ?>
                                    <?php $has_events_2 = TRUE; ?>
                                    <?php $item->comment == '' ? $comment = '' : $comment = '('.$item->comment.')'; ?>
                                    <?php echo "<span id='event_{$item->id}'><i>".$item->event->value.'</i> '.$item->time.'" <b>'.$item->player.'</b> '.$comment.' '.Html::anchor('#', '<span class="glyphicon glyphicon-remove"></span>', array('onclick' => "deleteMatchEvent({$item->id},2); return false;", 'title' => 'Удалить')).'</span><br>'; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>     
                            <?php echo $has_events_2 == FALSE ? 'События отсутствуют.' : '' ?>
                        </p>
                        <p>                            
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-events-team2">
                                Добавить событие
                            </a>
                        </p>
                    </div>
                </div>
            </div>	
            
            <hr>
		
            <div class="form-group">
                    <?php echo Form::label('Отчёт:', 'add_data', array('class'=>'control-label')); ?>
                    <?php echo Form::textarea('add_data', Input::post('add_data', isset($match) ? $match->add_data : ''), array('class' => 'col-md-8 form-control textarea_tinymce', 'rows' => 8, 'placeholder'=>'Отчёт')); ?>
            </div>

            <div class="form-group">
                <label class='control-label'>&nbsp;</label>
                <?php echo Form::submit('submit', 'Сохранить', array('class' => 'btn btn-primary')); ?>		
            </div>
	</fieldset>
<?php echo Form::close(); ?>

<script>
    function disable_change_table()
    {
        if ($("#form_status_id").val() == 1){
            $("#change-table").hide("slow");
        } else {
            $("#change-table").show("slow");
        }
    }
    
    $(document).ready(function() {        
        $('.datepicker').datepicker({format: 'dd.mm.yyyy', weekStart: 1});
        
        disable_change_table();
        
        $("#form_status_id").change(function() {
            disable_change_table();
        });
    } );      
</script>


<!-- Модальная форма добавления события для команды 1 -->
<div class="modal fade" id="modal-events-team1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Добавить событие для команды 1</h4>
      </div>
      <div class="modal-body">    
            <div class="alert alert-danger alert-dismissable" id="div-errors-form1" style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <span id="errors-form1"></span>
            </div>
          
        <?php echo Form::open(array('id' => 'form_events_team_1')); ?>    
            <div class="form-group">
                <?php echo Form::label('Событие*', 'event_id', array('class'=>'control-label')); ?>
                <?php echo Form::select('event_id', NULL, $events, array('class' => 'col-md-4 form-control', 'placeholder'=>'Игрок')); ?>
            </div>   

            <div class="form-group">
                <?php echo Form::label('Игрок*', 'player', array('class'=>'control-label')); ?>
                <?php echo Form::input('player', NULL, array('class' => 'col-md-4 form-control', 'placeholder'=>'Игрок')); ?>
            </div>  

            <div class="form-group">
                <?php echo Form::label('Минута*', 'time', array('class'=>'control-label')); ?>
                <?php echo Form::input('time', 1, array('class' => 'col-md-4 form-control', 'placeholder'=>'Минута')); ?>
            </div>   

            <div class="form-group">
                <?php echo Form::label('Комментарий', 'comment', array('class'=>'control-label')); ?>
                <?php echo Form::input('comment', NULL, array('class' => 'col-md-4 form-control', 'placeholder'=>'Комментарий')); ?>
            </div>    

            <?php echo Form::hidden('match_id', $match->id); ?>  
            <?php echo Form::hidden('team_id', $match->team_1->id); ?>  
        <?php echo Form::close(); ?>    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        <button type="button" class="btn btn-primary" onclick="addMatchEvent(1); return false;">Сохранить</button>
      </div>
    </div>
  </div>
</div>

<!-- Модальная форма добавления события для команды 2 -->
<div class="modal fade" id="modal-events-team2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Добавить событие для команды 2</h4>
      </div>
      <div class="modal-body">
            <div class="alert alert-danger alert-dismissable" id="div-errors-form2" style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <span id="errors-form2"></span>
            </div>
          
        <?php echo Form::open(array('id' => 'form_events_team_2')); ?>    
            <div class="form-group">
                <?php echo Form::label('Событие*', 'event_id', array('class'=>'control-label')); ?>
                <?php echo Form::select('event_id', NULL, $events, array('class' => 'col-md-4 form-control', 'placeholder'=>'Игрок')); ?>
            </div>   

            <div class="form-group">
                <?php echo Form::label('Игрок*', 'player', array('class'=>'control-label')); ?>
                <?php echo Form::input('player', NULL, array('class' => 'col-md-4 form-control', 'placeholder'=>'Игрок')); ?>
            </div>  

            <div class="form-group">
                <?php echo Form::label('Минута*', 'time', array('class'=>'control-label')); ?>
                <?php echo Form::input('time', 1, array('class' => 'col-md-4 form-control', 'placeholder'=>'Минута')); ?>
            </div>   

            <div class="form-group">
                <?php echo Form::label('Комментарий', 'comment', array('class'=>'control-label')); ?>
                <?php echo Form::input('comment', NULL, array('class' => 'col-md-4 form-control', 'placeholder'=>'Комментарий')); ?>
            </div>    

            <?php echo Form::hidden('match_id', $match->id); ?>  
            <?php echo Form::hidden('team_id', $match->team_2->id); ?>  
        <?php echo Form::close(); ?> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        <button type="button" class="btn btn-primary" onclick="addMatchEvent(2); return false;">Сохранить</button>
      </div>
    </div>
  </div>
</div>
