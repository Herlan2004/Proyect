$(document).ready(function() {
    $('.draggable').draggable({
        helper: 'clone',
        revert: 'invalid'
    });

    $('.droppable').droppable({
        accept: '.draggable',
        drop: function(event, ui) {
            const materiaId = ui.helper.data('materia');
            const horarioId = $(this).data('horario');
            const dia = $(this).data('dia');

            // Obtén el nombre de la materia
            const materiaNombre = ui.helper.text();
            $(this).empty();

            // Agrega el nombre de la materia a la celda droppable
            $(this).text(materiaNombre);

            // Aquí puedes guardar el registro en tu tabla periodo
            // utilizando una solicitud AJAX a tu controlador de Laravel.
            // Asegúrate de enviar materiaId y dia al controlador.

            // Ejemplo de solicitud AJAX (puedes usar Axios u otra librería):
            $.ajax({
                url: window.guardarRegistroUrl,
                type: 'POST',
                data: {
                    materia_id: materiaId,
                    horario_id:horarioId,
                    dia: dia,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Respuesta del servidor:', response);
                    //alert('Registro guardado con éxito');
                }
            });
        }
    });
});
