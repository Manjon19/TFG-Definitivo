<section class="row d-flex justify-content-center mt-5 mb-3">
    <div class="d-flex align-items-center">
        <div class="col">
            <form class="w-75 m-auto" method="post" name="form-perfil" action="<?php echo BASE_URL; ?>Usuarios/actualizar">
                <fieldset class="border border-2 rounded border-dark p-3 fw-bold" style="background-color: #BEF781" required>
                    <legend class="text-center">Mi Perfil:</legend>
                    <div class="form-group my-3">
                        <label for="nombre">Nombre: </label>
                        <input type="text" id="nombre" class="form-control" name="nombre" value="<?= $_SESSION['usuario']['nombre'] ?>">
                    </div>
                    <div class="form-group my-3">
                        <label for="dni">DNI: </label>
                        <input type="text" id="dni" class="form-control" name="dni" value="<?= $_SESSION['usuario']['dni'] ?>" readonly>
                    </div>
                    <div class="form-group my-3">
                        <label for="rol">Rol: </label>
                        <input type="hidden" name="rol" value="<?=$_SESSION['usuario']['rol']?>">
                        <input type="text" id="rol_" class="form-control" name="rol_" value="<?php echo $_SESSION['usuario']['rol'] == 0 ? "Cliente" : "Administrador" ?>" readonly>
                    </div>
                    <input type="hidden" name="oferta" value="<?= $ofer['cod_oferta']?>">
                    <?php
                        if (isset($ofer)) {
                        ?>
                         <div class="form-group my-3">
                            <label for="desc">Oferta:</label>
                            <textarea class="form-control" id="desc" readonly name="desc"><?=$ofer['descripcion']?></textarea>
                         </div>
                        <?php
                        }

                        if(isset($profe['dni'])){
                        ?>

                    <div class="from-group my-3">
                        <label for="profesor">Profesor:</label>
                        <input type="hidden" name="dni_profesor" value="<?= $profe['dni']?>">
                        <input type="text" id="profesor"  class="form-control" name="profesor" value="<?= $profe['nombre']?>" readonly />
                    </div>
                    <?php }?>
                    <div class="form-group my-3">
                        <div class="input-group">
                            <input type="password" class="form-control" value="<?= $_SESSION['usuario']['contrasena'] ?>" id="contrasena" name="contrasena" class="form-control" required minlength="6" maxlength="14">
                        </div>
                        
                        <div class="d-grid gap-2 my-3">
                            <button id="cambiarContra" class="btn btn-primary btn-block">
                                Guardar cambios
                            </button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

</section>
<script>
    $("#cambiarContra").on("click", (e) => {
        let regLetras = /^[A-Za-z]+(?:\s[A-Za-z]+)*$/
        e.preventDefault();
        if(regLetras.test($("#nombre").val())){
        let myForm = document.forms.namedItem("form-perfil");
        let formData = new FormData(myForm);
        if (formData.get("contrasena").length != 0) {
            $.ajax({
                method: 'POST',
                type: 'POST',
                url: "http://localhost/Autoescuela_Manjon/Usuarios/actualizar",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data)
                    if (data == 1) {
                        alert('Error al actualizar');
                    } else {
                        alert('Usuario actualizada');
                        window.location.href = "./perfil";
                    }
                },
                error: function() {
                    console.log("Error.");
                }
            })
        } else {
            alert("La contraseña no puede estár vacía");
            return;
        }
    }else {
        alert("Nombre no válido");
        return;
    }
    });

    $('#verClave').on('click', function(event) {
        event.preventDefault();
        let pass = $('#contrasena');
        if (pass.attr('type') == 'password') {
            pass.attr('type', 'text');
        } else {
            pass.attr('type', 'password');
        }
    });
</script>