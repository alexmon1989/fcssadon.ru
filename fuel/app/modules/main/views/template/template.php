<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ЛФК Шахтёр Садон<?php if (isset($page_title)) echo ' :: ' . $page_title; ?></title>

	<link rel="icon" type="image/icon" href="<?php echo Uri::create('assets/img/favicon.ico') ?>" />
	
    <?php echo Asset::css(array(
		'bootstrap.min.css',
		'desoslide/animate.css',
		'desoslide/jquery.desoslide.css',
		'style.css',
		'superfish/superfish.css',
    )); ?>
    
    <?php // JQuery загружаем вначале ?>
    <?php echo Asset::js(array(
		'https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js',
    )); ?>
    
    <script src="//vk.com/js/api/openapi.js" type="text/javascript" charset="windows-1251"></script>
    
    <?php if (isset($css)) echo Asset::css($css); ?>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      
    <div class="container">
        
        <?php echo render('template/header-top'); ?>
        
        <?php echo render('template/header-bottom'); ?>        
                
        <hr>
        
        <?php echo $content; ?>
        
        <hr>
        
        <?php echo render('template/footer'); ?> 
        
    </div><!-- /.container -->

    <?php echo Asset::js(array(
		'bootstrap.min.js',
		'jquery.desoslide.min.js',
		'superfish/hoverIntent.js',
		'superfish/superfish.js',
    )); ?>
    <?php if (isset($js)) echo Asset::js($js); ?>
                    
    <script>
        $(function() {            
            $('ul.sf-menu').superfish();
            
            $('#slider_thumbs').desoSlide({
                main: {
                    container: '#slider_main_image',
                    cssClass: 'img-responsive'
                },
                auto: {
                    start: true
                },
                effect: 'fade',
                caption: true
            });      
        });
    </script>
    
  </body>
</html>
