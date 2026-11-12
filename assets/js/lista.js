$(function () {
    function aviso(texto, tipo) {
        $('#aviso').empty().append($('<div class="alert" role="alert">').addClass('alert-' + tipo).text(texto));
    }
    function cargarPersonas() {
        $.getJSON('../../PersonaController.php', { accion: 'listar' }).done(function (respuesta) {
            if (!respuesta.ok) { aviso(respuesta.mensaje, 'danger'); return; }
            var $filas = $('#filas').empty();
            $.each(respuesta.datos, function (_, p) {
                var $fila = $('<tr>');
                $('<td>').text(p.IdPersona).appendTo($fila); $('<td>').text(p.Nombres).appendTo($fila);
                $('<td>').text(p.Apellidos).appendTo($fila); $('<td>').text(p.Identificacion).appendTo($fila);
                $('<td>').text(p.Genero).appendTo($fila); $('<td>').text(p.FechaNacimiento).appendTo($fila);
                $('<td>').text(p.Activo == 1 ? 'Activo' : 'Inactivo').appendTo($fila);
                var $acciones = $('<td>');
                $('<a class="btn btn-sm btn-warning me-1">Editar</a>').attr('href', 'editar.php?id=' + encodeURIComponent(p.IdPersona)).appendTo($acciones);
                var textoBoton = p.Activo == 1 ? 'Desactivar' : 'Activar';
                var estiloBoton = p.Activo == 1 ? 'btn-danger' : 'btn-success';
                $('<button type="button">').addClass('btn btn-sm ' + estiloBoton).text(textoBoton)
                    .attr('data-id', p.IdPersona).attr('data-activo', p.Activo == 1 ? 0 : 1).appendTo($acciones);
                $acciones.appendTo($fila); $filas.append($fila);
            });
            if (respuesta.datos.length === 0) { $filas.append('<tr><td colspan="8" class="text-center">No hay registros.</td></tr>'); }
        }).fail(function () { aviso('No se pudo cargar el listado.', 'danger'); });
    }
    cargarPersonas();
    $('#filas').on('click', 'button[data-id]', function () {
        var id = $(this).attr('data-id');
        var activo = $(this).attr('data-activo');
        var pregunta = activo == 1 ? '¿Activar esta persona?' : '¿Marcar esta persona como inactiva?';
        if (!window.confirm(pregunta)) { return; }
        $.post('../../PersonaController.php?accion=cambiarEstado', { IdPersona: id, Activo: activo }, function (r) {
            aviso(r.mensaje, r.ok ? 'success' : 'danger'); if (r.ok) { cargarPersonas(); }
        }, 'json').fail(function () { aviso('No se pudo cambiar el estado de la persona.', 'danger'); });
    });
});
