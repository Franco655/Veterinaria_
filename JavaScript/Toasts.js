var toastElemento = document.getElementById('liveToast');

if (toastElemento.dataset.mostrar === "true") {
    var toast = new bootstrap.Toast(toastElemento);
    toast.show();
}