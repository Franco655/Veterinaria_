
<?php
 require_once "../php/config.php";
if (isset($_POST['boton'])) {
  session_unset();
}

?>


  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/VentanaPrincipal.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Veterinaria Maldonado</title>
  </head>
  <body>


  <header style="background-color: rgba(13, 116, 10, 0.247); z-index: 1000;"
        class="sticky-top w-100 py-3">

  <div class="container-fluid px-4">
    <div class="row align-items-center">

      <!-- Logotipo -->
      <div class="col-12 col-md-4 text-center text-md-start mb-3 mb-md-0">
        <a href="../htmlPaginas/index.html" class="d-inline-block">
          <img
            src="../archivos.img/LogoVeterinaria2-removebg-preview.png"
            alt="Logo Veterinaria"
            class="img-fluid">
        </a>
      </div>

      <!-- Navegación / Acciones -->
      <div class="col-12 col-md-8">
        <nav class="d-flex justify-content-center justify-content-md-end gap-3 align-items-center flex-wrap">

          <a href="Registrarse.php" class="nav-link-custom">
            Registrarme
          </a>

          <a href="InicioSesion.php" class="nav-link-custom">
            Iniciar sesión
          </a>
<?php if(isset($_SESSION["Nombre"])){ ?>
          <div class="dropdown">
            <button class="btn btn-outline-light dropdown-toggle"
                    type="button"
                    id="dropdownMenuButton"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
              Usuario
            </button>


    <ul class="dropdown-menu dropdown-menu-end"
        aria-labelledby="dropdownMenuButton">

        <li>
         <form action="" method="POST">
        <button class="dropdown-item" name="boton" type="submit" class="btn-logout">
            Cerrar sesión
        </button>
    </form>
        </li>

        <li>
            <a class="dropdown-item" href="#">
                Tienda
            </a>
        </li>

        <?php if ($_SESSION["Rol"] == "Empleado" || $_SESSION["Rol"] == "Administrador"){ ?>

            <li>
                <a class="dropdown-item" href="ListaEmpleados.html">
                    Panel de control
                </a>
            </li>

        <?php } ?>

    </ul>

<?php } else { ?>


<?php } ?>
          </div>

        </nav>
      </div>

    </div>
  </div>

</header>


   <div id="carouselExampleSlidesOnly" class="shadow-lg carrusel carousel slide mb-5" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="../archivos.img/juguetes.jpeg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="../archivos.img/cambiar cartel veterinaria.jpeg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="../archivos.img/ImagenVeterinaria-Nombre.jpeg" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<section class="container my-5">
  <!-- Título con la clase personalizada -->
  <h2 class="titulo-seccion text-center mb-4">Nuestros Servicios</h2>

  <!-- Aquí van las tarjetas o contenido de tus servicios -->
</section>
<div class="container mt-4 text-center">

  <div class="row row-cols-2 row-cols-md-3 g-4 justify-content-center">

    <!-- Tarjeta 1 -->
    <div class="col d-flex justify-content-center">
      <div class="card h-100 shadow">
        <img src="../archivos.img/imagenRemplazo.jpg"
             class="card-img-top"
             alt="Peluquería">

        <div class="card-body">
          <h5 class="card-title">Peluquería</h5>
          <p class="card-text">
            Cortes y lavados a tus animales
          </p>
        </div>
      </div>
    </div>

    <!-- Tarjeta 2 -->
    <div class="col d-flex justify-content-center">
      <div class="card h-100 shadow">
        <img src="../archivos.img/imagenRemplazo.jpg"
             class="card-img-top"
             alt="Consulta">

        <div class="card-body">
          <h5 class="card-title">Consulta</h5>
          <p class="card-text">
            Consultas y revisiones meticulosas y rápidas
          </p>
        </div>
      </div>
    </div>

    <!-- Tarjeta 3 -->
    <div class="col d-flex justify-content-center">
      <div class="card h-100 shadow">
        <img src="../archivos.img/imagenRemplazo.jpg"
             class="card-img-top"
             alt="Recuperación">

        <div class="card-body">
          <h5 class="card-title">Recuperación</h5>
          <p class="card-text">
            Cuidados intensivos para una correcta recuperación
          </p>
        </div>
      </div>
    </div>

    <!-- Tarjeta 4 -->
    <div class="col d-flex justify-content-center">
      <div class="card h-100 shadow">
        <img src="../archivos.img/imagenRemplazo.jpg"
             class="card-img-top"
             alt="Operación">

        <div class="card-body">
          <h5 class="card-title">Operación</h5>
          <p class="card-text">
            Operaciones seguras y confiables
          </p>
        </div>
      </div>
    </div>

    <!-- Tarjeta 5 -->
    <div class="col d-flex justify-content-center">
      <div class="card h-100 shadow">
        <img src="../archivos.img/imagenRemplazo.jpg"
             class="card-img-top"
             alt="Vacunas">

        <div class="card-body">
          <h5 class="card-title">Vacunas</h5>
          <p class="card-text">
            Vacunación y prevención para tus mascotas
          </p>
        </div>
      </div>
    </div>

  </div>

</div>
<section class="container my-5">
  <!-- Título con la clase personalizada -->
  <h2 class="titulo-seccion text-center mb-4">Ubicación</h2>
</section>
<p class="mb-0 text-center">📍 Casa central: Batlle y Ordóñez esq C. Anaya</p>


<section class="mapa mx-auto">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d420454.3215327316!2d-55.343756297750204!3d-34.583942349552785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95751a87058c6699%3A0xc9c167eb036a1d59!2sVeterinaria%20Maldonado!5e0!3m2!1ses-419!2suy!4v1790041045630!5m2!1ses-419!2suy" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" class="shadow-lg"></iframe>
</section>
<section class="horario row text-center mx-auto">
<h4 class="col-12 titulo-horarios">Horarios</h4>
<p class="col-12">Lunes a viernes: 10:00 a 18:00</p>
<p class="col-12">Sabado: 9:00-13:00</p>
<p class="col-12">En caso de ser miembro, se podra llamar 24/7 para realizar consultas de emergencia</p>
</section>
  <footer class="bg-dark text-white mt-5 py-4">

  <div class="container">

    <div class="row text-center text-md-start">

      <!-- Información -->
      <div class="col-md-4 mb-3 mb-md-0">
        <h5>Veterinaria Maldonado</h5>
        <p class="mb-1">
          Cuidamos a tus mascotas como parte de la familia.
        </p>
        <p class="mb-0">
          Maldonado, Uruguay
        </p>
      </div>

      <!-- Redes sociales -->
      <div class="col-md-4 text-md-center">
        <h5>Redes sociales</h5>

        <a href="https://www.instagram.com/veterinaria_maldonado?stkn=dnZ5YmQ5NGlxcDZv" class="text-white text-decoration-none d-block mb-2">
          <i class="enlace bi bi-instagram"></i> Instagram
        </a>

        <a href="https://wa.me/59892003654" class="text-white text-decoration-none d-block mb-2">
          <i class="bi bi-whatsapp"></i> WhatsApp
        </a>
      </div>

    </div>

    <hr>

    <div class="text-center">
      <p class="mb-0">
        © 2026 Veterinaria Maldonado - Todos los derechos reservados
      </p>
    </div>

  </div>

</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
  </html>