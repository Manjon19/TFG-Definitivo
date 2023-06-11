<?php
class Vehiculos_m extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function leerVehiculos()
    {
        $cadSQL = "SELECT * FROM vehiculos order by 1";
        $this->consultar($cadSQL);
        return $this->resultado();
    }
    public function leerVehiculo($id)
    {
        $cadSQL = "SELECT * FROM vehiculos WHERE id=:id";
        $this->consultar($cadSQL);
        $this->enlazar(":id", $id);
        return $this->fila();
    }
    public function leerUltVehiculo()
    {
        $cadSQL = "select max(id) from vehiculos";
        $this->consultar($cadSQL);
        return $this->fila();
    }
    public function borrarVehiculo($id)
    {
        $cadSQL = "DELETE FROM vehiculos WHERE id=:id";
        $this->consultar($cadSQL);
        $this->enlazar(":id", $id);
        $this->ejecutar();
    }

    public function almacenarVehiculo($datos)
    {
        $cadSQL = "INSERT INTO vehiculos (tipo, marca, modelo, ref_img, carnet_necesario) 
            VALUES (:tipo, :marca, :modelo, :ref_img, :carnet_necesario)";
        $this->consultar($cadSQL);
        $this->enlazar("tipo", $datos['tipo']);
        $this->enlazar("marca", $datos['Marca']);
        $this->enlazar("modelo", $datos['Modelo']);
        $this->enlazar("ref_img", $datos['FILE']);
        $this->enlazar("carnet_necesario", $datos['tipo_carnet']);
        return $this->ejecutar();
    }
    public function almacenarProfe($datos)
    {
        $cadSQL = "select max(id) as id from vehiculos;";
        $this->consultar($cadSQL);
        $id_vehiculo = $this->fila();

        $cadSQL = "INSERT INTO profesores (dni,nombre,precio_practica,vehiculo_practica,tipo_Carnet) 
            VALUES (:dni,:nombre,:precio_practica,:vehiculo_practica,:tipo_Carnet)";
        $this->consultar($cadSQL);
        $this->enlazar("dni", $datos['dni']);
        $this->enlazar("nombre", $datos['nombre']);
        $this->enlazar("precio_practica", $datos['precio']);
        $this->enlazar("vehiculo_practica", $id_vehiculo['id']);
        $this->enlazar("tipo_Carnet", $datos['tipo_carnet']);
        return $this->ejecutar();
    }
    public function modificar($datos)
    {
        $cadSQL = 'UPDATE vehiculos as u, profesores as p
         SET u.tipo=:tipo, u.marca=:marca, u.modelo=:modelo,
          u.ref_img=:ref_img, u.carnet_necesario=:carnet_necesario, 
          p.nombre=:nombre , p.precio_practica=:precio_practica,
          p.tipo_Carnet=:tipo_Carnet WHERE u.id=:id and p.vehiculo_practica=u.id';
        $this->consultar($cadSQL);

        $this->enlazar("id", $datos['id']);
        $this->enlazar("tipo", $datos['tipo']);
        $this->enlazar("marca", $datos['Marca']);
        $this->enlazar("modelo", $datos['Modelo']);
        $this->enlazar("ref_img", $datos['FILE']);
        $this->enlazar("nombre", $datos['nombre']);
        $this->enlazar("precio_practica", $datos['precio']);
        $this->enlazar("tipo_Carnet", $datos['tipo_carnet']);
        $this->enlazar("carnet_necesario", $datos['tipo_carnet']);
        return $this->ejecutar();
    }
}
