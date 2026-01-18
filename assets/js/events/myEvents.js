document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("calendar");

  var calendar = new FullCalendar.Calendar(calendarEl, {
    locale: "pt-br",
    initialView: "dayGridMonth",
    themeSystem: "bootstrap",
    customButtons: {
        novoEvento: {
            text: "Novo evento",
            click: function () {
                window.location.href = "/events/create";
            }
        }
    },
    buttonHints: {
        today: "Hoje",
        month: "Mês",
        week: "Semana",
        day: "Dia",
        prev: "Mês anterior",
        next: "Próximo mês"
    },
    headerToolbar: {
        left: "prev next today",
        center: "title",
        right: "novoEvento"
    },
    buttonText: {
        today: "Hoje",
        month: "Mês",
        week: "Semana",
        day: "Dia"
    },
    events: events,
    selectable: true,
    selectMirror: true,
    select: function (arg) {
        let endDate = new Date(arg.endStr);
        endDate.setDate(endDate.getDate() - 1);
        window.location.href = `/events/create?start=${arg.startStr}&end=${endDate.toISOString().split('T')[0]}`;
    }
  });

  calendar.render();
});
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
// $('.obs-lembrete').tooltip()