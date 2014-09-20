<h2>Создание матча</h2>
<br>

<div class="alert alert-info alert-dismissable">
    <strong>Внимание!</strong> Здесь Вы создаёте сам матч, а потом с помощью редактирования Вы сможете заполнить состав, счёт, события, отчёт и т.д..<br>
    <strong><i>Выбирайте команды внимательно</i></strong>, т.к. в режиме редатктирования смена команд будет невозможна!
</div>


<?php echo render('competitions/matches/_form_create'); ?>

<p><?php echo Html::anchor('admin/competitions/matches', 'Назад'); ?></p>
