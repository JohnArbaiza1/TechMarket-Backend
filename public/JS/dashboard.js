//Definimos una función que se encrague de cambiar los mensaje a mostrar en el dashboard
function messageDashboard(opcion){
    let mensaje = '';

    //Definimos una estructura switch para asiganar los mensajes basados en la opçión seleccionada
    switch(opcion){
        case 'inicio':
            mensaje = 'Bienvenido';
            break;
        case 'usuarios':
            mensaje = 'Usuarios Registrados en el Sistema';
            break;
        case 'perfiles':
            mensaje = 'Datos de los Perfiles de Usuarios';
            break;
        case 'rol':
            mensaje = 'Roles Creados y Asignados';
            break;
        case 'publicaciones':
            mensaje = 'Datos de Publicaciones';
            break;
        case 'planes':
            mensaje = 'Información de planes';
            break;
        case 'cerrar sesion':
            mensaje = '';
            break;
        case 'otras':
            mensaje = '.';
            break;
        default:
            mensaje = 'Bienvenido'; // Mensaje por defecto si la opción no coincide con ningúna
    }

    document.querySelector('.datos h1').innerText = mensaje;
    //Guardamos el mensaje en localStorage para que persista después de recargar la página
    localStorage.setItem('mensaje', mensaje);
}

    // Evento que se ejecuta cuando el contenido del DOM ha sido completamente cargado
    document.addEventListener('DOMContentLoaded', function () {
        // Recuperamos el mensaje guardado en localStorage
        let mensajeGuardado = localStorage.getItem('mensaje');
        // Si hay un mensaje guardado, actualiza el contenido del elemento <h1> con ese mensaje
        if (mensajeGuardado) {
            document.querySelector('.datos h1').innerText = mensajeGuardado;
        }
    });