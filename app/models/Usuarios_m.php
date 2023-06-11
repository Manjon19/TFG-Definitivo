<?php
class Usuarios_m extends Model
{

  public function __construct()
  {
    parent::__construct();
  }
  public function leerTodos()
  {
    $cadSQL = "SELECT * FROM usuarios order by 1";
    $this->consultar($cadSQL);
    return $this->resultado();
  }

  public function leerUsuario($dni)
  {
    $cadSQL = "SELECT * FROM usuarios WHERE dni=:dni";
    $this->consultar($cadSQL);
    $this->enlazar(":dni", $dni);
    return $this->fila();
  }
  public function contarTodo()
  {
    $cadSQL = "select * from usuarios where rol =" . 0;
    $this->consultar($cadSQL);
    $num['usuarios'] = count($this->resultado());
    $cadSQL = "select * from vehiculos where id !=" . 0;
    $this->consultar($cadSQL);
    $num['vehiculos'] = count($this->resultado());
    $cadSQL = "select * from profesores where dni not like " . 0;
    $this->consultar($cadSQL);
    $num['profes'] = count($this->resultado());
    $cadSQL = "select * from t_ofertas where cod_oferta != " . 0;
    $this->consultar($cadSQL);
    $num['ofertas'] = count($this->resultado());
    return $num;
  }

  public function insertar($datos){
    $user=$this->leerUsuario($datos['dni']);
    if($user){
      echo "<script>
      alert('Ya existe un usuario con ese dni');
      window.location.href='./registro'
      </script>";
      exit();
    }else{
      $cadSQL="INSERT INTO usuarios (dni, nombre, contrasena, rol, oferta, dni_profesor)
      VALUES (:dni, :nombre, :contrasena, :rol, :oferta, :dni_profesor)";
     $this->consultar($cadSQL);
     $this->enlazar("dni",$datos['dni']);
     $this->enlazar("nombre",$datos['nombre']);
     $this->enlazar("contrasena",$datos['contrasena']);
     $this->enlazar("rol",$datos['rol']);
     $this->enlazar("oferta",$datos['oferta']);
     $this->enlazar("dni_profesor",$datos['dni_profesor']);
     return $this->ejecutar();
    }
  }
  
  public function modificar($datos)
  {
    $cadSQL="UPDATE usuarios SET nombre=:nombre,contrasena=:contrasena,
    rol=:rol,oferta=:oferta,dni_profesor=:dni_profesor WHERE dni=:dni";
    $this->consultar($cadSQL);
    $this->enlazar("dni",$datos["dni"]);
    $this->enlazar("nombre",$datos["nombre"]);
    $this->enlazar("contrasena",$datos["contrasena"]);
    $this->enlazar("rol",$datos["rol"]);
    $this->enlazar("oferta",$datos["oferta"]);
    $this->enlazar("dni_profesor",$datos["dni_profesor"]);

    return $this->ejecutar();
  }
  public function eliminar($dni){
    $cadSQL = "DELETE FROM usuarios WHERE dni=:dni";
        $this->consultar($cadSQL);
        $this->enlazar(":dni", $dni);
        $this->ejecutar();
  }
}
