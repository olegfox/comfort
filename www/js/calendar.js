function openDay(id){
    $.post("/afisha_json", {"id" : id.substr(0, id.length - 1)}, function(data){
        $(".lenta").html(data);
//        afi = $.parseJSON(data);
//        $(".lenta").html("");
//        for(i = 0; i < afi.length; i++){
//            if(i%4 == 0){
//                $(".lenta").append('<div class="cub cub-last" id="cub'+i+'"></div>');
//            }else{
//                $(".lenta").append('<div class="cub" id="cub'+i+'"></div>');
//            }
//            $(".lenta #cub"+i).html("<h2><a href='#'>"+afi[i].id+"</a></h2>\n\
//            <a href='/afisha/"+afi[i].slug+"'> <img src='"+afi[i].img+"' alt='"+afi[i].img+"' />\n\
//            <div class='description'>"+afi[i].date+"<br/>"+afi[i].name+"\n\
//            </div></a>");
//        }
    });
    return false;
}
$(function() {
    //alert($(".calendar_json").val());
    calendar_json = $.parseJSON($(".calendar_json").val());
    for (i = 0; i < calendar_json.length; i++) {
        calendar_json[i]['start'] = new Date(calendar_json[i]['start'] * 1000);
        calendar_json[i]['end'] = new Date(calendar_json[i]['end'] * 1000);
    }
    $('#calendar').fullCalendar({
        monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthNamesShort: ['Янв.', 'Фев.', 'Март', 'Апр.', 'Май', 'οюнь', 'οюль', 'Авг.', 'Сент.', 'Окт.', 'Ноя.', 'Дек.'],
        dayNames: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
        dayNamesShort: ["ВС", "ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ"],
        buttonText: {
            prev: "&nbsp;&#9668;&nbsp;",
            next: "&nbsp;&#9658;&nbsp;",
            prevYear: "&nbsp;&lt;&lt;&nbsp;",
            nextYear: "&nbsp;&gt;&gt;&nbsp;",
            today: "Сегодня",
            month: "Месяц",
            week: "Неделя",
            day: "День"
        },
        eventBackgroundColor : "#000",
        height: 400,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        events: calendar_json,
        eventRender: function (event, element) {
            element.find('span.fc-event-title').html(element.find('span.fc-event-title').text());           
        }        
    });
});
