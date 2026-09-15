// 1. Cambiamos el selector para buscar el formulario por su ID
var miFormulario = document.getElementById('liveToastBtn')
var toastLiveExample = document.getElementById('liveToast')

if (miFormulario) {
  // 2. Escuchamos el evento 'submit' en lugar de 'click'
  miFormulario.addEventListener('submit', function (event) {

    // 3. Opcional: Detiene el envío real a otra página para poder ver el Toast
    event.preventDefault()

    // 4. Mostramos el Toast de Bootstrap
    var toast = new bootstrap.Toast(toastLiveExample)
    toast.show()

    // Nota: Si necesitas enviar los datos al servidor después de mostrar el Toast,
    // puedes usar fetch() (AJAX) aquí mismo dentro de la función.
  })
}
