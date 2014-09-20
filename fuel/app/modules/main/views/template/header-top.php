<div class="row">
    <div class="col-md-12 header-top">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <div class="header-logo">
                            <?php echo Html::anchor(Uri::base(), Html::img('assets/img/header-logo.png', array('alt' => 'Главная страница', 'title' => 'Главная страница'))); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xs-12 header-menu">
                        <ul class="list-inline sf-menu">
                            <li><?php echo Html::anchor(Uri::base(), 'Главная'); ?></li>                            
                            <li>
                                <?php echo Html::anchor(Uri::current().'#',  'Команда'); ?>
                                <ul>
                                    <li><?php echo Html::anchor(Uri::create('team/core'), 'Основной состав'); ?></li>
                                    <li><?php echo Html::anchor(Uri::create('team/staff'), 'Персонал'); ?></li>
                                    <li><?php echo Html::anchor(Uri::create('team/past'), 'Все игроки'); ?></li>
                                    <li><?php echo Html::anchor(Uri::create('team/calendar'), 'Календарь матчей'); ?></li>
                                </ul>
                            </li>
                            <li>
                                <?php echo Html::anchor(Uri::current().'#',  'Клуб'); ?>
                                <ul>
                                    <li><?php echo Html::anchor(Uri::create('club/management'), 'Руководство клуба'); ?></li>
                                    <li><?php echo Html::anchor(Uri::create('club/history'), 'История'); ?></li>
                                    <li><?php echo Html::anchor(Uri::create('club/sponsors'), 'Спонсоры и партнёры'); ?></li>
                                    <li><?php echo Html::anchor(Uri::create('club/stadium'), 'Стадион'); ?></li>
                                </ul>
                            </li>
                            <li>
                                <?php echo Html::anchor(Uri::current().'#', 'Медиа'); ?>
                                <ul>
                                    <li><?php echo Html::anchor(Uri::create('media/photos'), 'Фото'); ?></li>
                                    <li><?php echo Html::anchor(Uri::create('media/videos'), 'Видео'); ?></li>
                                </ul>
                            </li>
                            <li>
                                <?php echo Html::anchor(Uri::current().'#', 'Новости'); ?>
                                <ul>
                                    <li><?php echo Html::anchor(Uri::create('news/shahter'), 'Новости ФК "Шахтёр Садон"'); ?></li>
                                    <li><?php echo Html::anchor(Uri::create('news/interviews'), 'Интервью'); ?></li>
                                    <li><?php echo Html::anchor(Uri::create('news/fond'), 'Фонд "Быть добру"'); ?></li>
                                </ul>
                            </li>
                            <li><?php echo Html::anchor(Uri::create('contacts'), 'Контакты'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-xs-12">
                <div class="header-top-left">
                    <div class="row">
                        <div class="col-md-12">
                            <!--<input type="text" class="form-control input-sm search" placeholder="Введите слово для поиска">-->
                        </div>    
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="social-links">
                                <?php echo Html::anchor(Uri::create('https://www.facebook.com/fcssadon'), Html::img('assets/img/fb-logo.png')); ?>
                                <?php echo Html::anchor('http://vk.com/lfcshakhtersadon', Html::img('assets/img/vk-logo.png')); ?>
                                <?php echo Html::anchor(Uri::create('https://twitter.com/Shakhtersadon'), Html::img('assets/img/twitter-logo.png')); ?>
                                <?php echo Html::anchor('https://www.youtube.com/channel/UCYXaBM5Ang-cBlv1JWaiRLQ', Html::img('assets/img/youtube-logo.png')); ?>
                            </div>
                        </div>                                   
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="vk-vidget">
                                <script type="text/javascript" src="//vk.com/js/api/openapi.js?111"></script>
                                <!-- VK Widget -->
                                <div id="vk_groups"></div>
                                <script type="text/javascript">
                                VK.Widgets.Group("vk_groups", {mode: 1, width: "277", height: "200", color1: '66e339', color2: '006109', color3: '006109'}, 53220872);
                                </script>
                            </div>
                        </div>
                    </div>
                </div>                        
            </div>
        </div>    
    </div>
</div>