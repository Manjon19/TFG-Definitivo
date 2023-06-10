<?php
defined("BASEPATH") or die("No se permite la entrada directa a este script");

class Usuarios extends Controller
{
    private $usuarios_m;
    private $ofertas_m;
    private $vehiculo_m;
    private $profesor_m;
    public function __construct()
    {
        $this->usuarios_m = $this->load_model("Usuarios_m");
        $this->ofertas_m=$this->load_model("Ofertas_m");
        $this->profesor_m=$this->load_model("Profesores_m");
        parent::__construct();
    }
    public function index($parametros = [])
    {
        setcookie('oferta', null, 0, "/");
        setcookie('dni_prof', null, 0, "/");
        $vista = "usuarios_v";  //Vista por defecto
        $menu = "admin/menuAdmin"; //Menu por defecto 
        $datos['params'] = $parametros;
        $datos['listado']= $this->genListado();
        $this->load_view("plantilla/cabecera");
        $this->load_view($menu);
        $this->load_view($vista, $datos);
        $this->load_view("plantilla/pie");
    }
    public function genListado(){
        $usuarios=$this->usuarios_m->leerTodos();
        $list = "<h2 class='text-center'>Listado de clientes</h2>";
        foreach($usuarios as $user){
            if($user['rol']==0){
                $list.='<div class=" mb-2  d-flex justify-content-around" >
                <div class="card h-100  d-flex justify-content-between">
                 <div class="card-body d-flex justify-content-center flex-column">
                        <h3 class="card-title">Nombre: </h3>
                        <p class="card-text">'.  $user["nombre"].'</p>
                        <h4 class="card-tittle">DNI: </h4>
                        <p class="card-text">'. $user["dni"].'</p>
                        <a href="'. BASE_URL .'Usuarios/borrar/'. $user["dni"] .'" class="btn btn-danger w-100 mt-2 mx-auto">Dar de baja</a>
                    </div>
            </div>';
            }
        }
        return $list;
    }
    public function borrar($dni){
        $this->usuarios_m->eliminar($dni);
        echo "<script>
            alert('Usuario eliminado correctamente');
            window.location.href='../index';
        </script>";
    }
    public function perfil(){
        $vista = "perfil_v";
        if($_SESSION['usuario']['rol']==0){
            $menu = "plantilla/menu_loged";
        }else{
            $menu = "admin/menuAdmin";
        }
         
        $datos['user']=$this->usuarios_m->leerUsuario($_SESSION['usuario']["dni"]);
        if(isset($datos['user']['oferta']) && $datos['user']['oferta']!=0){
            $datos['ofer']=$this->ofertas_m->leerOferta($datos['user']['oferta']);
        }
        $datos['profe']=$this->profesor_m->leerProfesor($_SESSION['usuario']['dni_profesor']);
        $this->load_view("plantilla/cabecera");
        $this->load_view($menu);
        $this->load_view($vista,$datos);
        $this->load_view("plantilla/pie");
    }
    public function actualizar(){
        if(isset($_POST['dni'])){
            $_SESSION['usuario']['contrasena']=$_POST['contrasena'];
            $_POST['contrasena'] = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
            $this->usuarios_m->modificar($_POST);
            $_SESSION['usuario']['nombre']=$_POST['nombre'];

            echo 0;
        }else{
            echo 1;
        }
    }
}
