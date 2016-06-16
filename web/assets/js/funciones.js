/**
 * Funcion para validar archivos antes a la subida
 *
 * @param {type} id_archivo
 * @returns {Boolean}
 */
function nombre_ar(id_archivo) {
    var archivo = document.getElementById(id_archivo).value;

    if (navigator.userAgent.indexOf('Linux') != -1) {
        var SO = "Linux";
    } else if ((navigator.userAgent.indexOf('Win') != -1) && (navigator.userAgent.indexOf('95') != -1)) {
        var SO = "Win";
    } else if ((navigator.userAgent.indexOf('Win') != -1) && (navigator.userAgent.indexOf('NT') != -1)) {
        var SO = "Win";
    } else if (navigator.userAgent.indexOf('Win') != -1) {
        var SO = "Win";
    } else if (navigator.userAgent.indexOf('Mac') != -1) {
        var SO = "Mac";
    } else {
        var SO = "no definido";
    }

    if (SO = "Win") {
        var arr_ruta = archivo.split("\\");
    } else {
        var arr_ruta = archivo.split("/");
    }


    var nombre_archivo = (arr_ruta[arr_ruta.length - 1]);
    var ext_validas = /\.(pdf|jpeg|jpg|png)$/i.test(nombre_archivo);
    if (!ext_validas) {
        borrar(id_archivo);
        alert("Archivo con extensión no válida\nSu archivo: " + nombre_archivo + "\n DEBE ELEGIR ARCHIVOS |JPG|JPEG|PNG|PDF");
        return false;
    }

}

function borrar(id_archivo) {
    var vacio = document.getElementById(id_archivo).value = "";
}



$('#rut').Rut({
    on_error: function () {
        alert('Rut incorrecto');
    }
});

$('#loginRut').Rut({
    on_error: function () {
        alert('Rut incorrecto');
    }
});

$('#registroRut').Rut({
    on_error: function () {
        alert('Rut incorrecto');
    }
});

$('#registroERut').Rut({
    on_error: function () {
        alert('Rut incorrecto');
    }
});

$(function () {


    $('#btnRegistro').click(function (event) {

        var archivo = $('#archivo').val();
        var terminos = $('#terminos').val();


        if(archivo && terminos){
            return
        }else{
            alert("Debe adjuntar fotocopia de su cedula de identidad y Archivo de Términos y condiciones firmado");
        }

    });


});

/*
 $(document).ready(function () {
 $('ul.nav > li').click(function (e) {
 e.preventDefault();
 $('ul.nav > li').removeClass('active');
 $(this).addClass('active');
 });
 });
 */
/*
 $('.nav li a').click(function (e) {
 $('.nav li.active').removeClass('active');
 var $this = $(this);
 if (!$this.hasClass('active')) {
 $this.addClass('active');
 }
 e.preventDefault();
 });
 */


/*
 Script Firma Mitocondria

 Este script, agregar el div al footer de la pagina, es necesario que exista la etiqueta footer, o al menos un div con clase footer.
 */

$(document).ready(function () {

    



    /*
     * FUNCIONES AJAX PARACOMUNAS
     */


    $(document).ready(function () {

        $('#registroRegion').change(function (e) {
            e.preventDefault();

            var data = $(this).val();
            $.ajax({
                method: "post",
                url: "/verant/provincias/comuna/" + data,
                dataType: "json",
                success: function (data) {
                    var $ciudad = $('#registroCiudad');
                    $ciudad.html('<option>Ciudades</option>');

                    for (var i = 0, total = data.length; i < total; i++) {
                        $ciudad.append('<option value="' + data[i].id + '">' + data[i].nombre + '</option>');
                    }

                }
            });
        });

        $('#registroCiudad').change(function (e) {
            e.preventDefault();

            var data = $(this).val();
            $.ajax({
                method: "post",
                url: "/verant/provincias/comuna/" + data,
                dataType: "json",
                success: function (data) {
                    var $comuna = $('#registroComuna');
                    $comuna.html('<option>Comunas</option>');

                    for (var i = 0, total = data.length; i < total; i++) {
                        $comuna.append('<option value="' + data[i].id + '">' + data[i].nombre + '</option>');
                    }

                }
            });
        });
    });

});
