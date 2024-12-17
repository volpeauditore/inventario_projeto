$(document).ready(function() {
    $('.hub-item').on('click', function() {
        var link = $(this).data('link'); // Pega o valor do data-link
        if (link) { // Verifica se existe um link
            window.location.href = link; // Redireciona para o link
        }
    });
});
