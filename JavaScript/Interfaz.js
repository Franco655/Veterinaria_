document.addEventListener('DOMContentLoaded', function () {

    // ===== TOAST =====
    var toastElemento = document.getElementById('liveToast');

    if (toastElemento && toastElemento.dataset.mostrar === "true") {
        var toast = new bootstrap.Toast(toastElemento);
        toast.show();
    }

    // ===== MODAL DE USUARIO =====
    const modal = document.getElementById('exampleModal');

    if (modal) {
        modal.addEventListener('show.bs.modal', function (event) {

            const boton = event.relatedTarget;

            const ci = boton.getAttribute('data-ci');
            const nombre = boton.getAttribute('data-nombre');

            console.log("CI seleccionado:", ci);

            const campoCi = document.getElementById('CiDelete');
            const campoNombre = document.getElementById('nombreUsuario');

            if (campoCi) {
                campoCi.value = ci;
                console.log("CI colocado en input:", campoCi.value);
            }

            if (campoNombre) {
                campoNombre.textContent = nombre;
            }
        });
    }
});