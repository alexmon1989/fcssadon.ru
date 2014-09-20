<!DOCTYPE html>
<html>
<head>    
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css(array(
            'bootstrap.css', 
            'datepicker.css',
            'jquery.dataTables.css'
        )); ?>
	<style>
		body { margin: 50px; }
	</style>
	<?php echo Asset::js(array(
		'http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js',
		'bootstrap.js',
                'admin_scripts.js',
                'tinymce/tinymce.min.js',
                'tinymce_settings.js',
                'bootstrap-datepicker.js',
                'jquery.dataTables.min.js',
                'jquery.dataTables.bootstrap.js'
	)); ?>
	<script>
		$(function(){ $('.topbar').dropdown(); });
	</script>
</head>
<body>
	<?php if ($current_user): ?>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">ЛФК "Шахтёр" Садон</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
                                    <li class="dropdown <?php echo Arr::get($subnav, 'articles'); ?>">
                                        <a href="#" class="dropdown-toggle " data-toggle="dropdown">Статьи <b class="caret"></b></a>                    
                                        <ul class="dropdown-menu">
                                            <li><?php echo Html::anchor('admin/articles/index', 'Список статей') ?></li>
                                            <li><?php echo Html::anchor('admin/articles/categories', 'Список категорий') ?></li>
                                        </ul>                    
                                    </li>
                                    <li class="dropdown <?php echo Arr::get($subnav, 'media'); ?>">
                                        <a href="#" class="dropdown-toggle " data-toggle="dropdown">Медиа <b class="caret"></b></a>                    
                                        <ul class="dropdown-menu">
                                            <li><?php echo Html::anchor('admin/media/photos/categories', 'Фото') ?></li>
                                            <li><?php echo Html::anchor('admin/media/videos', 'Видео') ?></li>
                                        </ul>                    
                                    </li>
                                    <li class="<?php echo Arr::get($subnav, 'sliders'); ?>"><?php echo Html::anchor('admin/sliders', 'Слайдер'); ?></li>
                                    <li class="<?php echo Arr::get($subnav, 'videos'); ?>"><?php echo Html::anchor('admin/videos', 'Видео'); ?></li>
                                    <li class="<?php echo Arr::get($subnav, 'players'); ?>">
                                        <a href="#" class="dropdown-toggle " data-toggle="dropdown">Команда <b class="caret"></b></a>      
                                        <ul class="dropdown-menu">
                                            <li><?php echo Html::anchor('admin/players', 'Игроки'); ?></li>
                                            <li><?php echo Html::anchor('admin/staff', 'Персонал'); ?></li>
                                        </ul>                                        
                                    </li>
                                    <li class="<?php echo Arr::get($subnav, 'votes'); ?>"><?php echo Html::anchor('admin/votes/edit', 'Голосование'); ?></li>
                                    <li class="dropdown <?php echo Arr::get($subnav, 'competitions'); ?>">
                                        <a href="#" class="dropdown-toggle " data-toggle="dropdown">Соревнования <b class="caret"></b></a>                    
                                        <ul class="dropdown-menu">
                                            <li><?php echo Html::anchor('admin/competitions/teams', 'Команды') ?></li>
                                            <li><?php echo Html::anchor('admin/competitions/seasons', 'Сезоны') ?></li>
                                            <li><?php echo Html::anchor('admin/competitions/matches', 'Матчи') ?></li>
                                            <li><?php echo Html::anchor('admin/competitions/tables', 'Таблицы') ?></li>
                                            <li><?php echo Html::anchor('admin/competitions/strikers', 'Бомбардиры (настройки)') ?></li>
                                        </ul>                    
                                    </li>
                                    <li class="<?php echo Arr::get($subnav, 'users'); ?>"><?php echo Html::anchor('admin/users', 'Пользователи'); ?></li>
				</ul>
				<ul class="nav navbar-nav pull-right">
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $current_user->username ?> <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                                <li><?php echo Html::anchor('admin/logout', 'Выход') ?></li>
                                        </ul>
                                    </li>
				</ul>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1><?php echo $title; ?></h1>
				<hr>
<?php if (Session::get_flash('success')): ?>
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<p>
					<?php echo implode('</p><p>', (array) Session::get_flash('success')); ?>
					</p>
				</div>
<?php endif; ?>
<?php if (Session::get_flash('error')): ?>
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<p>
					<?php echo implode('</p><p>', (array) Session::get_flash('error')); ?>
					</p>
				</div>
<?php endif; ?>
			</div>
			<div class="col-md-12">
<?php echo $content; ?>
			</div>
		</div>
		<hr/>
		<footer>
			<p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
			<p>
				<a href="http://fuelphp.com">FuelPHP</a> is released under the MIT license.<br>
				<small>Version: <?php echo e(Fuel::VERSION); ?></small>
			</p>
		</footer>
	</div>
</body>
</html>
