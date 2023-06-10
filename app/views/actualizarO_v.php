<h1 style="text-align:center">Actualización de oferta</h1>
<section class="row d-flex justify-content-around mt-5 ">
    <form enctype="multipart/form-data" method="post" name="form-oferta" id="form-oferta">
        <fieldset class="border border-2 rounded border-dark p-3 fw-bold" style="background-color: #BEF781">
        <h2>Oferta:</h2>
            <div class="form-group my-3">
                <label for="cod_oferta">Código de la oferta: </label>
                <input type="text" id="cod_oferta" class="form-control" value="<?php echo $oferta['cod_oferta']; ?>" name="cod_oferta" class="form-control" readonly required>
            </div>
            <div class="form-group my-3">
                <label for="descripcion">Descripcion: </label>
                <textarea name="descripcion"  class="form-control" id="descripcion" required>
                <?php echo $oferta['descripcion']; ?>
                </textarea>
    <input type="hidden" name="fecha_limite" value="<?= $oferta['fecha_limite'];?>">
            <div class="form-group my-3">
                <label for="descuento">descuento : </label>
                <input type="number" name="descuento" value="<?php echo intval($oferta['descuento']); ?>" class="form-control" id="descuento" required>
            </div>
            <h4>Datos del profesor:</h4>
            <div class="form-group my-3">
                <label for="dni_prof">Dni: </label>
                <input type="text" id="dni_prof" class="form-control" value="<?php echo $dni_p['dni']; ?>" name="dni_prof" placeholder="00000000A" pattern="[0-9]{8}[A-Z]{1}" minlength="9" maxlength="9" class="form-control" readonly required>
            </div>
            <div class="form-group my-3">
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" value="<?php echo $dni_p['nombre']; ?>" class="form-control" id="nombre" readonly required>
            </div>
            <div class="form-group my-3 d-flex justify-content-center">
                <button type="button" id="save" class="btn btn-primary w-25 mx-auto text-center">
                    Guardar
                </button>
            </div>

            <script>
                //Llamada AJAX 
                $("#save").on("click", (e) => {
                    e.preventDefault();
                    let myForm = document.forms.namedItem("form-oferta");
                    let formData = new FormData(myForm);
                    if (formData.get('descripcion').trim().length<5) {
                        alert("La descripción no puede tener menos de 5 caractéres")
                        return;
                    }else{
                        if(formData.get("descuento").length==0){
                            alert("El descuento no puede estar vacío");
                            return;
                        }else{
                            $.ajax({
                            method: 'POST',
                            type: 'POST',
                            url: 'http://localhost/Autoescuela_Manjon/Ofertas/updateO',
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                console.log(data)
                                if (data == 1) {
                                    console.log(formData);
                                    alert('Error al actualizar ');
                                } else {
                                    alert('oferta actualizada correctamente');
                                    window.location.href = "./list_Oferta";
                                }
                            },
                            error: function() {
                                console.log("Error.");
                            }
                        })
                        }
                    }
                        
                    
                });
            </script>
        </fieldset>
    </form>
</section>