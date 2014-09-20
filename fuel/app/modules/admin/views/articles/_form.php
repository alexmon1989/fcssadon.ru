<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>		
		<div class="form-group">
			<?php echo Form::label('Название', 'title', array('class'=>'control-label')); ?>

				<?php echo Form::input('title', Input::post('title', isset($article) ? $article->title : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Название')); ?>

		</div>
        
        <div class="form-group">
			<?php echo Form::label('Категория', 'category_id', array('class'=>'control-label')); ?>
                <?php
                    echo Form::select('category_id',  Input::post('category_id', isset($article) ? $article->category_id : NULL), $categories, array('class' => 'col-md-4 form-control')
                    );
                ?>            
		</div>
            
                <div class="form-group">
			<?php echo Form::label('Превью статьи', 'preview', array('class'=>'control-label')); ?>

				<?php echo Form::textarea('preview', Input::post('preview', isset($article) ? $article->preview : ''), array('class' => 'col-md-8 form-control textarea_tinymce', 'rows' => 8, 'placeholder'=>'Превью')); ?>

		</div>
        
		<div class="form-group">
			<?php echo Form::label('Текст', 'full_text', array('class'=>'control-label')); ?>

				<?php echo Form::textarea('full_text', Input::post('full_text', isset($article) ? $article->full_text : ''), array('class' => 'col-md-8 form-control textarea_tinymce', 'rows' => 8, 'placeholder'=>'Текст')); ?>

		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Сохранить', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>