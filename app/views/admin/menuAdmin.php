<nav class="row ">	<!-- Menu principal -->
	<ul class="nav nav-pills d-flex justify-content-center">
		<li class="nav-item">
			<a class="nav-link active" aria-current="page" href="<?php echo BASE_URL; ?>Inicio/index">Inicio</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="<?php echo BASE_URL;?>Usuarios/index">Listado de clientes</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="<?php echo BASE_URL;?>Vehiculos/index">Listado de profesores</a>
		</li>
        <li class="nav-item">
			<a class="nav-link" href="<?php echo BASE_URL;?>Vehiculos/anadirVehiculo">Alta de profesor y vehículo</a>
		</li>
        <li class="nav-item">
			<a class="nav-link" href="<?php echo BASE_URL;?>Ofertas/list_Oferta">Listado de ofertas</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="<?php echo BASE_URL;?>Usuarios/perfil">Mi perfil</a>
		</li>
	</ul>
</nav>				<!-- Fin Menu principal -->
<script>
	$(".nav .nav-link").removeClass("active");
	let activo=$("a[href='"+location.href+"']");
	if (activo.length>0) {
		activo.addClass("active");
	}else{
		$(".nav .nav-link").eq(0).addClass("active");
	}
</script>