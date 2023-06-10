<h1 style="text-align:center">Alta de vehiculo junto profesorado</h1>
<section class="row d-flex justify-content-around mt-5 ">
    <form enctype="multipart/form-data" method="post" name="form-vehiculo" id="form-vehiculo">
        <fieldset class="border border-2 rounded border-dark p-3 fw-bold" style="background-color: #BEF781">
            <h2>Profesor:</h2>
            <div class="form-group my-3">
                <label for="dni">Dni: </label>
                <input type="text" id="dni" class="form-control" name="dni" placeholder="00000000A" pattern="[0-9]{8}[A-Z]{1}" minlength="9" maxlength="9" class="form-control" required>
            </div>
            <div class="form-group my-3">
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" class="form-control" id="nombre" required>
            </div>
            <div class="form-group my-3">
                <label for="precio">Precio por práctica: </label>
                <input type="number" name="precio" class="form-control" id="precio" required>
            </div>
            <h2>Vehiculo:</h2>
            <div class="form-group my-3">
                <label for="ref_img">Imagen del vehículo: </label>
                <input type="file" name="ref_img" id="ref_img" class="form-control" placeholder="ref_img" required accept="image/png,image/jpeg,image/jpg" />
            </div>

            <div class="form-group my-3">
                <label for="tipo">Tipo de vehículo:</label>
                <select name="tipo" id="tipo" class="form-select" required>
                    <option value="">Elige un vehiculo...</option>
                    <option value="Motocicleta">Motocicleta</option>
                    <option value="Ciclomotor">Ciclomotor</option>
                    <option value="Turismo">Turismo</option>
                    <option value="Camion">Camión</option>
                </select>
            </div>
            <div class="form-group my-3">
                <label for="Marca">Marca:</label>
                <select name="Marca" id="Marca" class="form-select" required>

                </select>
            </div>
            <div class="form-group my-3">
                <label for="Modelo">Modelo:</label>
                <select name="Modelo" id="Modelo" class="form-select" required>
                </select>
            </div>
            <div class="form-group my-3">
                <label for="tipo_carnet">Tipos de permisos:</label>
                <input type="text" name="tipo_carnet" id="tipo_carnet" class="form-control" style="width:49px;" readonly>

            </div>
            <div class="form-group my-3 d-flex justify-content-center">
                <button type="button" id="save" class="btn btn-primary w-25 mx-auto text-center">
                    Guardar
                </button>
            </div>
            <script>
                //Array con distintos vehiculos, modelos y marcas
                const cochesAutoescuela = [{
                        tipo: "Motocicleta",
                        marcasModelos: [{
                                marca: "Yamaha",
                                modelos: ["MT-03", "YZF-R125", "XSR155"]
                            },
                            {
                                marca: "Honda",
                                modelos: ["CBR500R", "CB300R", "CB125F"]
                            },
                            {
                                marca: "Kawasaki",
                                modelos: ["Ninja 400", "Z400", "Versys-X 300"]
                            }
                        ]
                    },
                    {
                        tipo: "Camion",
                        marcasModelos: [{
                                marca: "Volvo",
                                modelos: ["FH16", "FH12", "FMX"]
                            },
                            {
                                marca: "Scania",
                                modelos: ["R-Series", "G-Series", "P-Series"]
                            },
                            {
                                marca: "Mercedes-Benz",
                                modelos: ["Actros", "Arocs", "Antos"]
                            }
                        ]
                    },
                    {
                        tipo: "Turismo",
                        marcasModelos: [{
                                marca: "Volkswagen",
                                modelos: ["Golf", "Polo", "Passat"]
                            },
                            {
                                marca: "Ford",
                                modelos: ["Focus", "Fiesta", "Mondeo"]
                            },
                            {
                                marca: "Renault",
                                modelos: ["Clio", "Megane", "Captur"]
                            }
                        ]
                    },
                    {
                        tipo: "Ciclomotor",
                        marcasModelos: [{
                                marca: "Peugeot",
                                modelos: ["Speedfight 4", "Kisbee", "Tweet"]
                            },
                            {
                                marca: "Yamaha",
                                modelos: ["Aerox 4", "Neo's 4", "D'elight"]
                            },
                            {
                                marca: "Kymco",
                                modelos: ["Super Dink 125", "Agility City", "People S 125"]
                            }
                        ]
                    }
                ];
                //Inicio a vacío de array donde se guardarn distintos valores del anterior array
                let vehiculos = [];
                //Bandera para comprobar que la imagen se haya seleccionado junto con el método correspondiente
                let fileFlag = false;
                $("#ref_img").on("blur", (e) => {
                    if (e.target.value.length > 0) {
                        fileFlag = true;
                    } else {
                        fileFlag = false;
                    }
                })
                //Evento que rellenará el select de marcas de vehiculos
                $("#tipo").on("change", (e) => {
                    let options = "<option value=''>Elige una marca...</option>";
                    cochesAutoescuela.forEach((v) => {
                        if (v.tipo == e.target.value) {
                            vehiculos = v.marcasModelos;
                        }
                    });
                    vehiculos.forEach((m) => {
                        options += "<option value='" + m.marca + "'>" + m.marca + "</option>"
                    })
                    $("#Marca").html(options);
                    cambiarModelo($("#Marca").val());
                    //Cambio de los valores del tipo de carnet con respecto a la seleccion
                    switch (e.target.value) {
                        case "Motocicleta":
                            $("#tipo_carnet").val("A1");
                            $("#tipo_carnet").textContent = "A1";
                            break;
                        case "Ciclomotor":
                            $("#tipo_carnet").val("AM");
                            $("#tipo_carnet").textContent = "AM";
                            break;
                        case "Turismo":
                            $("#tipo_carnet").val("B");
                            $("#tipo_carnet").textContent = "B";
                            break;
                        case "Camion":
                            $("#tipo_carnet").val("C");
                            $("#tipo_carnet").textContent = "C";
                            break;

                        default:
                            break;
                    }
                });
                //Evento que rellenará el campo de modelos de vehículos con respecto a seleccion de la marca
                $("#Marca").on("change", (e) => {
                    cambiarModelo(e.target.value);
                })
                //Función que se llama en el evento para cambiar valor del select modelo
                function cambiarModelo(marca) {
                    let model = []
                    vehiculos.forEach((v) => {
                        if (marca == v.marca) {
                            model = v.modelos;
                        }
                    })
                    let options = "<option value=''>Elige un modelo...</option>";
                    model.forEach((modelo) => {
                        options += "<option value='" + modelo + "'>" + modelo + "</option>"
                    })
                    $("#Modelo").html(options);
                }
                //Llamada AJAX para insertar el usuario comprobando las distintas validaciones
                $("#save").on("click", (e) => {
                    e.preventDefault();
                    let myForm = document.forms.namedItem("form-vehiculo");
                    let formData = new FormData(myForm);
                    let regDni = /^[0-9]{8}[A-Z]{1}$/;
                    let regLetras = /^[A-Za-z]+(?:\s[A-Za-z]+)*$/
                    if (!regDni.test(formData.get("dni"))) {
                        alert("El dni introducido no es válido");
                        return;
                    } else if (!regLetras.test(formData.get("nombre"))) {
                        alert("El nombre introducido no es válido");
                        return;
                    } else if (formData.get("precio") < 12) {
                        alert("El precio por práctica debe de ser de 12€ o más");
                        return;
                    } else if (!fileFlag) {
                        alert("Debe de seleccionar una imagen para el vehículo");
                        return;
                    } else if ($("#Modelo").val() != "") {
                       /*  $.ajax({
                            url: "http://localhost/Autoescuela_Manjon/Vehiculos/insertarV",
                            type: "POST",
                            data: formData,
                            success: function(data, status) {
                                console.log(data, status);
                            }
                        }
                        )
                        $.ajax({
                            url:"http://localhost/Autoescuela_Manjon/Vehiculos/insertarP",
                            data: formData,
                            type:"POST",
                            success:function(data) {
                                if (data == 1) {
                                    alert('Ya existe un profesor con ese dni. ');
                                } else {
                                    alert('Vehiculo y profesor insertados');
                                    window.location.href = "./anadirVehiculo";
                                }
                            }
                        }); */
                        $.ajax({
                            method: 'POST',
                            type: 'POST',
                            url: 'http://localhost/Autoescuela_Manjon/Vehiculos/insertarVP',
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                console.log(data)
                                if (data == 1) {
                                    alert('Ya existe un profesor con ese dni. ');
                                } else {
                                    alert('Vehiculo y profesor insertados');
                                    window.location.href = "./anadirVehiculo";
                                }
                            },
                            error: function() {
                                console.log("Error.");
                            }
                        }) 
                    } else {
                        alert("Tienes que seleccionar un vehículo");
                        return;
                    }
                });
            </script>
        </fieldset>
    </form>
</section>