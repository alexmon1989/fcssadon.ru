/**
 * Функция посылает POST-запрос на сервер с информацией о сортировке
 * 
 * @param string orderBy по какому полю сортировать
 * @param string orderMethod порядок сортировки
 */
function sortArticles(orderBy, orderMethod){
    $.post('/admin/articles', {order_by : orderBy, order_method : orderMethod}, function( data ) {
        location.reload();
    });
}

/**
 * Добавление события матча (гол, карточка и т.д.)
 */
function addMatchEvent(formNum){   
    var str = $("#form_events_team_"+formNum).serialize();
    
    $.post('/admin/competitions/matches/add_event', str, function( data ) {
        data = $.parseJSON(data);
        if (data.code == 0){
            // Показываем ошибки
            $('#errors-form'+formNum).html(data.errors);
            $('#div-errors-form'+formNum).show('slow');
        }
        
        if (data.code == 1){
            // Скрываем форму 
            $("#modal-events-team"+formNum).modal('hide');
            
            // очищаем поля
            $("#form_events_team_"+formNum)[0].reset();
            
            // Очищаем и скрываем ошибки
            $('#div-errors-form'+formNum).hide('slow');
            $('#errors-form'+formNum).html('');
            
            // Добавляем событие на экран
            showMatchEvents(data.post.match_id, data.post.team_id, formNum);
        }
    });
}

/**
 * Подгрузка и показ события матча
 * 
 * @param int matchId id матча
 * @param int teamId id команды
 * @param int teamNum команда на экране (1 - домашняя, 2 - гостевая)
 */
function showMatchEvents(matchId, teamId, teamNum){
    $.get('/admin/competitions/matches/get_events/'+matchId+'/'+teamId, function (data) {
        data = $.parseJSON(data);
                
        if (data.length == 0){            
            $("#events_team"+teamNum).html('События отсутствуют.');
        } else {
            var s = '';
            $.each(data, function (key, value){
               var comment = ''; 
               if (value.comment != '') 
                   comment = ' (' + value.comment + ')';
               s += '<span>'+'<i>'+value.event_value+'</i> '+value.time+'" <b>'+value.player+'</b>' + comment +' <a onclick="deleteMatchEvent('+value.match_event_id+','+teamNum+'); return false;" href="#"><span class="glyphicon glyphicon-remove"></span></a>'+'</span><br>';
            });
            $("#events_team"+teamNum).html(s);
        }
            
    });
}

/**
 * Удаление события матча
 * 
 * @param int matchEventId id события матча
 * @param int teamNum команда на экране (1 - домашняя, 2 - гостевая)
 */
function deleteMatchEvent(matchEventId, teamNum)
{
    $.post('/admin/competitions/matches/delete_event', {match_event_id : matchEventId}, function( data ) {
        data = $.parseJSON(data);
        showMatchEvents(data.match_id, data.team_id, teamNum);
    });
}

function setTableOnMain(id, show)
{
    $.post("/admin/competitions/tables/set_table_on_main", { id: id, show: show }, function( data ) {
        location.reload();
    });
}

function getTeams(season_id)
{
    $.getJSON("/admin/competitions/seasons/get_teams_by_season", { season_id: season_id }, function( data ) {
        var items = [];
        $.each( data, function( key, val ) {
            items.push( "<option value='" + val.id + "'>" + val.val + "</option>" );
        });
        items = items.join( "" );
        $("#form_team_1_id").html();
        $("#form_team_2_id").html();
        $("#form_team_1_id").html(items);
        $("#form_team_2_id").html(items);
    });
}