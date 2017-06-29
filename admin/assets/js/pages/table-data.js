$(document).ready(function () {
    $('#example').DataTable({
      "order": [ 0, 'desc' ],
        "pageLength": 25,
        language: {
            sLengthMenu: "Mostrar _MENU_ resultados",
            zeroRecords: "Ningún registro encontrado.",
            search: "Búsqueda",
            info: "Mostrando _PAGE_ de _PAGES_ pág.",
            infoEmpty: "0 Registros",
            infoFiltered: "(filtered from _MAX_ total records)",
            paginate: {
                first: "Primera",
                last: "LaUUltima",
                next: "Siguiente",
                previous: "Anterior",
                searching: false
            }
        }
    });
    $('.dataTables_length select').addClass('browser-default');
});
