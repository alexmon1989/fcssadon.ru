<div class="row footer">           
    <div class="col-md-12">
        <div class="row footer-top"></div>
        <div class="row footer-center">
            <div class="col-md-3">

<!--Openstat-->
<span id="openstat2364349"></span>
<script type="text/javascript">
var openstat = { counter: 2364349, image: 5081, color: "258559", next: openstat };
(function(d, t, p) {
var j = d.createElement(t); j.async = true; j.type = "text/javascript";
j.src = ("https:" == p ? "https:" : "http:") + "//openstat.net/cnt.js";
var s = d.getElementsByTagName(t)[0]; s.parentNode.insertBefore(j, s);
})(document, "script", document.location.protocol);
</script>
<!--/Openstat-->

            </div>

            <div class="col-md-7">
                <div class="menu">
                    <ul class="list-inline">
                        <li><?php echo Html::anchor(Uri::base(), 'Главная'); ?></li>
                        <li><?php echo Html::anchor(Uri::create('team/calendar'), 'Календарь матчей'); ?></li>
                        <li><?php echo Html::anchor(Uri::create('team/core'), 'Команда'); ?></li>
                        <li><?php echo Html::anchor(Uri::create('media'), 'Медиа'); ?></li>
                        <li><?php echo Html::anchor(Uri::create('news/shahter'), 'Новости о клубе'); ?></li>
                        <li><?php echo Html::anchor(Uri::create('contacts'), 'Контакты'); ?></li>
                    </ul>
                </div>
                <div class="text">
                    Использование материалов без согласия с администрацией сайта запрещено.<br>
                    Со всеми вопросами и предложениями свяжитесь с нами через <?php echo Html::anchor(Uri::create('contacts'), 'Контакты'); ?>.<br>
                    Дата открытия сайта: 09.04.2014
                </div>
            </div>

            <div class="col-md-2 logo">&nbsp;</div>
        </div>
        <div class="row footer-bottom">fcssadon.ru &COPY; <?php echo date('Y'); ?>. Все права защищены.</div>
    </div>
</div>