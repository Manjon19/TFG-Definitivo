<?php
defined("BASEPATH") or die("No se permite la entrada directa a este script");

class Vehiculos extends Controller
{
    private $vehiculos_m, $profesores_m;
    public function __construct()
    {
        parent::__construct();
        $this->vehiculos_m = $this->load_model("Vehiculos_m");
        $this->profesores_m = $this->load_model(("Profesores_m"));
    }
    public function index($parametros = [])
    {
        setcookie('oferta', null, 0, "/");
        setcookie('dni_prof', null, 0, "/");
        $datos['vehiculos'] = $this->vehiculos_m->leerVehiculos();
        $vista = "vehiculos_v";  //Vista por defecto
        $menu = "plantilla/menu"; //Menu por defecto 
        if (isset($_SESSION['usuario'])) {
            $menu = "plantilla/menu_loged";
            if ($_SESSION['usuario']['rol'] == 1) {
                $menu = "admin/menuAdmin";
            }
        }
        $datos["listado"] = $this->genListado();
        $datos['params'] = $parametros;
        $this->load_view("plantilla/cabecera");
        $this->load_view($menu);
        $this->load_view($vista, $datos);
        $this->load_view("plantilla/pie");
    }
    public function genListado()
    {
        //obtener todos los datos que se mostrarán
        $profesores = $this->profesores_m->leerProfesores();
        $list = "";
        foreach ($profesores as $prof) {
            if (isset($_SESSION['usuario'])) {
                if ($prof['dni'] !== "0") {
                    $vehiculo = $this->vehiculos_m->leerVehiculo($prof['vehiculo_practica']);
                    $list .= '<div class="col-4 mb-2 ">
                   <div class="card h-100 ">
                       <img class="card-img-top mx-auto mt-3 w-50" src="' . BASE_URL . "app/assets/img/vehiculos/" . $vehiculo["ref_img"] . '" alt="' . BASE_URL . "app/assets/img/vehiculos/" . $vehiculo["ref_img"] . '">
                       <div class="card-body d-flex justify-content-center flex-column align-items-center">
                          
                       <h6 class="card-title">Nombre: ' . $prof["nombre"] . '</h6>
                           <p class="card-text">Precio: ' . $prof["precio_practica"] . '€ / práctica</p>
                           <p class="card-text">Tipo de permiso: ' . $prof["tipo_Carnet"] . '</p>
                            
                           <button class="btn btn-warning w-50 mt-2" onclick="actualizarVP(`' . $prof["dni"] . '`)">Actualizar</button>
                            <a class="btn btn-danger w-50 mt-2" href="' . BASE_URL . 'vehiculos/eliminarVehiculo/' . $vehiculo['id'] . '">Eliminar</a>
                           </div>
                   </div>
               </div>';
                }
            } else {
                if ($prof['dni'] !== "0") {
                    $vehiculo = $this->vehiculos_m->leerVehiculo($prof['vehiculo_practica']);
                    $list .= '<div class="col-4 mb-2 ">
             <div class="card h-100 ">
                 <img class="card-img-top mx-auto w-50" src="' . BASE_URL . "app/assets/img/vehiculos/" . $vehiculo["ref_img"] . '" alt="' . BASE_URL . "app/assets/img/vehiculos/" . $vehiculo["ref_img"] . '">
                 <div class="card-body d-flex justify-content-center flex-column align-items-center">
                     <h6 class="card-title">Nombre: ' . $prof["nombre"] . '</h6>
                     <p class="card-text">Precio: ' . $prof["precio_practica"] . '€ / práctica</p>
                     <p class="card-text">Tipo de permiso: ' . $prof["tipo_Carnet"] . '</p>
                 </div>
             </div>
         </div>';
                }
            }
        }
        return $list;
    }
    public function eliminarVehiculo($id)
    {
        //llamada al método del modelo que se encarga de hacer la query de borrar vehículos
        $this->vehiculos_m->borrarVehiculo(intval($id));
        //Relocalizo la página para cargar el nuevo listado
        header("Location:" . BASE_URL . "vehiculos/");
    }
    public function anadirVehiculo()
    {
        $this->load_view("plantilla/cabecera");
        $this->load_view("admin/menuAdmin");
        $this->load_view("anadirVehiculo_v");
        $this->load_view("plantilla/pie");
    }
    public function insertarVP()
    {
        $profUser = $this->profesores_m->leerProfesor($_POST['dni']);
        if (!$profUser) {
            $_POST['FILE'] = $_FILES['ref_img']['name'];
            //mueve la imagen a la carpeta específica
            move_uploaded_file($_FILES['ref_img']['tmp_name'], ROOT . 'app/assets/img/vehiculos/' . $_FILES['ref_img']['name']);
            $this->vehiculos_m->almacenarVehiculo($_POST);
            $this->vehiculos_m->almacenarProfe($_POST);
            echo "0";
        } else {
            echo "1";
        }
    }
    public function actualizarVP($data)
    {
        $datos['dni_p'] = $this->profesores_m->leerProfesor($data);
        $datos['vehiculo'] = $this->vehiculos_m->leerVehiculo($datos['dni_p']['vehiculo_practica']);
        $this->load_view("plantilla/cabecera");
        $this->load_view("admin/menuAdmin");
        $this->load_view("actualizarP_v", $datos);
        $this->load_view("plantilla/pie"); 
    }
    public function updateVP(){
        if(isset($_POST['dni'])){
            //modificar para si selecciona foto
            if(!isset($_FILES['ref_img']['name'])){
                $_POST['FILE'] = $_POST["ref_img"];
            }else{
                $_POST['FILE'] = $_FILES['ref_img']['name'];
            }
            $this->vehiculos_m->modificar($_POST);
            echo 0;
        }else{
            echo 1;
        }
    }
}
