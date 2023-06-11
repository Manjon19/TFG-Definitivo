<?php
defined("BASEPATH") or die("No se permite la entrada directa a este script");

class Ofertas extends Controller
{
    private $ofertas_m;
    private $vehiculo_m;
    private $profesor_m;
    public function __construct()
    {
        $this->vehiculo_m = $this->load_model("Vehiculos_m");
        $this->ofertas_m = $this->load_model("Ofertas_m");
        $this->profesor_m = $this->load_model("Profesores_m");
        parent::__construct();
    }
    public function index($parametros = [])
    {
        setcookie('oferta', null, 0, "/");
        setcookie('dni_prof', null, 0, "/");
        $vista = "ofertas_v";  //Vista por defecto
        $menu = "plantilla/menu"; //Menu por defecto
        $datos['params'] = $parametros;
        $datos['Ofertas'] = $this->ofertas_m->leerOfertas();
        foreach ($datos['Ofertas'] as $ind => $oferta) {
            if ($oferta['dni_prof'] != null) {
                $datos['imagenes'][$ind] = $this->imgOferta($oferta['cod_oferta']);
            }
        }
        $this->load_view("plantilla/cabecera");
        $this->load_view($menu);
        $this->load_view($vista, $datos);
        $this->load_view("plantilla/pie");
    }
    public function imgOferta($cod_oferta)
    {
        $ofer = $this->ofertas_m->leerOferta($cod_oferta);
        $profe = $this->profesor_m->ProfesorOferta($ofer['dni_prof']);
        return $this->vehiculo_m->leerVehiculo($profe['vehiculo_practica']);
    }
    public function list_Oferta()
    {
        $vista = "listOfertas_v";  //Vista por defecto
        $menu = "plantilla/menu_loged";
        if ($_SESSION['usuario']['rol'] == 1) {
            $menu = "admin/menuAdmin";
        }

        $datos["listado"] = $this->genListado();
        $this->load_view("plantilla/cabecera");
        $this->load_view($menu);
        $this->load_view($vista, $datos);
        $this->load_view("plantilla/pie");
    }
    public function genListado()
    {
        $ofertas = $this->ofertas_m->leerOfertas();

        $list = "";
        foreach ($ofertas as $ofer) {
            if ($ofer['cod_oferta'] != 0) {
                $profesor = $this->profesor_m->ProfesorOferta($ofer['dni_prof']);
                $list .= '<div class="my-2 col-4">
                <div class="card h-100 ">
                <img class="card-img-top mx-auto mt-3 w-50 img-fluid" src="' . BASE_URL . '"app/assets/img/vehiculos/" ' . $this->imgOferta($ofer['cod_oferta'])['ref_img']. '" alt="" />
                <div class="card-body d-flex justify-content-center flex-column align-items-center">
                   
                <h6 class="card-title">Nombre del profesor: ' . $profesor["nombre"] . '</h6>
                    <p class="card-text"><b>Descripción:</b> ' . $ofer["descripcion"] . '</p>
                    <p class="card-text"><b>Descuento:</b> ' . $ofer["descuento"] . '%</p>
                     
                    <button class="btn btn-warning w-50 mt-2" onclick="actualizarOferta(`' . $ofer["cod_oferta"] . '`)">Actualizar</button>
                     <a class="btn btn-danger w-50 mt-2" href="' . BASE_URL . 'ofertas/eliminarOferta/' . $ofer['cod_oferta'] . '">Eliminar</a>
                    </div>
            </div>
            </div>';
            }
        }
        return $list;
    }
    public function actualizarOferta($cod){
        $datos['oferta'] = $this->ofertas_m->leerOferta($cod);
        $datos['dni_p'] = $this->profesor_m->ProfesorOferta($datos['oferta']['dni_prof']);
        $this->load_view("plantilla/cabecera");
        $this->load_view("admin/menuAdmin");
        $this->load_view("actualizarO_v", $datos);
        $this->load_view("plantilla/pie"); 

    }
    public function updateO(){
        if(isset($_POST['dni_prof'])){
            $this->ofertas_m->modificar($_POST);
            echo 0;
        }else{
            echo 1;
        }
    }
    public function eliminarOferta($cod)
    {
        //llamada al método del modelo que se encarga de hacer la query de borrar vehículos
        $this->ofertas_m->borrarOferta($cod);
        //Relocalizo la página para cargar el nuevo listado
        header("Location:" . BASE_URL . "Ofertas/list_Oferta");
    }
}
