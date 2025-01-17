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
        var e = new Date(l.now()),
            a = this;

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
            events: function(info, successCallback, failureCallback) {
                // Carregar eventos do banco de dados
                $.ajax({
                    url: 'fetch_events.php', // Script PHP para buscar eventos
                    dataType: 'json',
                    success: function(data) {
                        successCallback(data);
                    },
                    error: function() {
                        failureCallback();
                    }
                });
            },
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

        a.$btnNewEvent.on("click", function () {
            a.onSelect({
                date: new Date(),
                allDay: !0
            });
        });

        function formatDateToMySQLFormat(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear(),
                hour = '' + d.getHours(),
                minute = '' + d.getMinutes(),
                second = '' + d.getSeconds();
        
            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;
            if (hour.length < 2) hour = '0' + hour;
            if (minute.length < 2) minute = '0' + minute;
            if (second.length < 2) second = '0' + second;
        
            return [year, month, day].join('-') + ' ' + [hour, minute, second].join(':');
        }
        
        a.$formEvent.on("submit", function (e) {
            e.preventDefault();
            var t, n = a.$formEvent[0];
            n.checkValidity()
                ? (a.$selectedEvent
                    ? (a.$selectedEvent.setProp("title", l("#event-title").val()),
                       a.$selectedEvent.setProp("classNames", [l("#event-category").val()]))
                    : (t = {
                        titulo: l("#event-title").val(),      // Use "titulo" em vez de "title"
                        inicio: formatDateToMySQLFormat(a.$newEventData.date), // Formata a data corretamente
                        fim: formatDateToMySQLFormat(a.$newEventData.end),   // Formata a data corretamente
                        descricao: l("#event-description").val(),  // Se você tem uma descrição, também envie esse campo
                        categoria: l("#event-category").val()  // "category" -> "categoria"
                    }),
                // Salvar no banco de dados via AJAX
                $.ajax({
                    url: 'update_event.php', // Script PHP para salvar o evento
                    method: 'POST',
                    data: {
                        id: a.$selectedEvent.id,  // Enviar o ID do evento para o PHP
                        titulo: t.titulo,
                        inicio: t.inicio,
                        fim: t.fim,
                        categoria: t.categoria
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            a.$calendarObj.refetchEvents(); // Recarrega os eventos
                            a.$modal.hide();
                        } else {
                            console.log('Erro ao atualizar evento');
                        }
                    },
                    error: function() {
                        console.log('Erro na requisição AJAX');
                    }
                }))
                : (e.stopPropagation(), n.classList.add("was-validated"));
        });
        
        

        l(a.$btnDeleteEvent.on("click", function () {
            if (a.$selectedEvent) {
                // Excluir o evento do banco de dados
                $.ajax({
                    url: 'delete_event.php', // Script PHP para excluir evento
                    method: 'POST',
                    data: { id: a.$selectedEvent.id },
                    success: function () {
                        a.$selectedEvent.remove();
                        a.$selectedEvent = null;
                        a.$modal.hide();
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
