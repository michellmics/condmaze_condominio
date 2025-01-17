!(function (l) {
    "use strict";

    function e() {
        this.$body = l("body"),
        this.$modal = new bootstrap.Modal(document.getElementById("event-modal"), {
            backdrop: "static"
        }),
        this.$calendar = l("#calendar"),
        this.$formEvent = l("#form-event"),
        this.$btnNewEvent = l("#btn-new-event"),
        this.$btnDeleteEvent = l("#btn-delete-event"),
        this.$btnSaveEvent = l("#btn-save-event"),
        this.$modalTitle = l("#modal-title"),
        this.$calendarObj = null,
        this.$selectedEvent = null,
        this.$newEventData = null;
    }

    e.prototype.onEventClick = function (e) {
        this.$formEvent[0].reset(),
        this.$formEvent.removeClass("was-validated"),
        this.$newEventData = null,
        this.$btnDeleteEvent.show(),
        this.$modalTitle.text("Editar Evento"),
        this.$modal.show(),
        this.$selectedEvent = e.event,
        l("#event-title").val(this.$selectedEvent.title),
        l("#event-category").val(this.$selectedEvent.classNames[0]);
    };

    e.prototype.onSelect = function (e) {
        this.$formEvent[0].reset(),
        this.$formEvent.removeClass("was-validated"),
        this.$selectedEvent = null,
        this.$newEventData = e,
        this.$btnDeleteEvent.hide(),
        this.$modalTitle.text("Adicionar Novo Evento"),
        this.$modal.show(),
        this.$calendarObj.unselect();
    };

    e.prototype.init = function () {
        var a = this;

        // Carregar eventos do banco de dados
        $.ajax({
            url: 'fetch_event.php', // Script PHP para buscar eventos
            dataType: 'json',
            success: function(data) {
                var events = data.map(function(event) {
                    return {
                        id: event.id,
                        title: event.title,
                        start: event.start,
                        end: event.end
                    };
                });
                a.$calendarObj = new FullCalendar.Calendar(a.$calendar[0], {
                    locale: 'pt-br',
                    slotDuration: "00:15:00",
                    slotMinTime: "08:00:00",
                    slotMaxTime: "19:00:00",
                    themeSystem: "bootstrap",
                    bootstrapFontAwesome: !1,
                    buttonText: {
                        today: "Hoje",
                        month: "Mês",
                        week: "Semana",
                        day: "Dia",
                        list: "Lista",
                        prev: "Anterior",
                        next: "Próximo"
                    },
                    initialView: "dayGridMonth",
                    handleWindowResize: !0,
                    height: l(window).height() - 200,
                    headerToolbar: {
                        left: "prev,next today",
                        center: "title",
                        right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
                    },
                    events: events, // Carregar eventos inicialmente
                    editable: !0,
                    droppable: !0,
                    selectable: !0,
                    dateClick: function (e) {
                        a.onSelect(e);
                    },
                    eventClick: function (e) {
                        a.onEventClick(e);
                    }
                });

                a.$calendarObj.render();
            }
        });

        a.$btnNewEvent.on("click", function () {
            a.onSelect({
                date: new Date(),
                allDay: !0
            });
        });

        a.$formEvent.on("submit", function (e) {
            e.preventDefault();
            var t, n = a.$formEvent[0];
            n.checkValidity()
                ? (a.$selectedEvent
                    ? (a.$selectedEvent.setProp("title", l("#event-title").val()),
                       a.$selectedEvent.setProp("classNames", [l("#event-category").val()]),
                       // Atualizar evento no banco de dados
                       $.ajax({
                           url: 'update_event.php',
                           method: 'POST',
                           data: JSON.stringify({
                               id: a.$selectedEvent.id,
                               inicio: a.$selectedEvent.start,
                               fim: a.$selectedEvent.end
                           }),
                           contentType: 'application/json',
                           success: function(response) {
                               if (response.status === 'success') {
                                   a.$calendarObj.refetchEvents();
                                   a.$modal.hide();
                               }
                           }
                       }))
                    : (t = {
                        title: l("#event-title").val(),
                        start: a.$newEventData.date,
                        allDay: a.$newEventData.allDay,
                        className: l("#event-category").val()
                    }, 
                    // Adicionar evento no banco de dados
                    $.ajax({
                        url: 'add_event.php',
                        method: 'POST',
                        data: JSON.stringify({
                            titulo: t.title,
                            inicio: t.start,
                            fim: t.end
                        }),
                        contentType: 'application/json',
                        success: function(response) {
                            if (response.status === 'success') {
                                a.$calendarObj.refetchEvents();
                                a.$modal.hide();
                            }
                        }
                    })),
                a.$modal.hide())
                : (e.stopPropagation(), n.classList.add("was-validated"));
        });

        l(a.$btnDeleteEvent.on("click", function () {
            if (a.$selectedEvent) {
                // Excluir evento do banco de dados
                $.ajax({
                    url: 'delete_event.php',
                    method: 'POST',
                    data: JSON.stringify({ id: a.$selectedEvent.id }),
                    contentType: 'application/json',
                    success: function (response) {
                        if (response.status === 'success') {
                            a.$selectedEvent.remove();
                            a.$selectedEvent = null;
                            a.$modal.hide();
                        }
                    }
                });
            }
        }));
    };

    l.CalendarApp = new e();
    l.CalendarApp.Constructor = e;
})(window.jQuery),
(function () {
    "use strict";
    window.jQuery.CalendarApp.init();
})();
