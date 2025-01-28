
function loadNotifications() {
    $.ajax({
        url: 'get_notifications.php',  // Arquivo PHP que retorna as notificações
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Limpar notificações anteriores
            $('#notifications-container').empty();

            // Adicionar as notificações à página
            data.forEach(function(notification) {
                $('#notifications-container').append('<div class="notification">' + notification.message + '</div>');
            });
        }
    });
}
setInterval(loadNotifications, 5000);
