$(function () {
    var $form = $('#formPersona');
    var accion = $form.attr('data-accion');
    var id = new URLSearchParams(window.location.search).get('id');
    function aviso(texto, tipo) {
        $('#aviso').empty().append($('<div class="alert" role="alert">').addClass('alert-' + tipo).text(texto));
    }
    if (accion === 'crear') {
        $('#Contrasena').prop('required', true); $('#ayudaContrasena').text('(obligatoria)');
    } else {
        if (!id) { aviso('Falta el número de la persona.', 'danger'); $form.find(':input').prop('disabled', true); return; }
        $('#ayudaContrasena').text('(déjala vacía para conservarla)');
        $.getJSON('../../PersonaController.php', { accion: 'obtener', id: id }).done(function (r) {
            if (!r.ok) { aviso(r.mensaje, 'danger'); return; }
            $.each(r.datos, function (campo, valor) { $('#' + campo).val(valor); });
            $('#Contrasena').val('');
        }).fail(function () { aviso('No se pudo cargar la persona.', 'danger'); });
    }
    $form.on('submit', function (evento) {
        evento.preventDefault();
        if (!this.checkValidity()) { this.reportValidity(); return; }
        $.post('../../PersonaController.php?accion=' + accion, $form.serialize(), function (r) {
            aviso(r.mensaje, r.ok ? 'success' : 'danger'); if (r.ok) { window.location.href = 'index.php'; }
        }, 'json').fail(function () { aviso('No se pudo guardar la información.', 'danger'); });
    });
});
