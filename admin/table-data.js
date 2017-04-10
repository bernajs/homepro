$(document).ready(function () {
    $('#example').DataTable({
        language: {
            sLengthMenu: "Mostrar _MENU_ resultados",
            zeroRecords: "No se encontró ningún registro.",
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