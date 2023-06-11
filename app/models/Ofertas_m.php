<?php
    class Ofertas_m extends Model{

        public function __construct(){
            parent::__construct();
        }

        public function leerOfertas(){
            $cadSQL="SELECT * FROM t_ofertas order by 1";
            $this->consultar($cadSQL);
            return $this->resultado();
        }
    
        public function leerOferta($cod_oferta){
            $cadSQL="SELECT * FROM t_ofertas WHERE cod_oferta=:cod_oferta";
            $this->consultar($cadSQL);
            $this->enlazar(":cod_oferta",$cod_oferta);
            return $this->fila();
        }
        
        public function insertar($datos){
            // Recibimos los datos del formulario en un array
            // Obtenemos cadena con las columnas desde las claves del array asociativo
            $columnas=implode(",",array_keys($datos)); 
            // Campos de columnas
            $campos=array_map(
                function($col){
                    return ":".$col;
                },array_keys($datos));
            $parametros=implode(",",$campos); // Parametros para enlazar
            $cadSQL="INSERT INTO t_ofertas ($columnas) VALUES ($parametros)";
            $this->consultar($cadSQL);   // Preparar sentencia
            for($ind=0;$ind<count($campos);$ind++){    // Enlace de parametros
                $this->enlazar($campos[$ind],$datos[array_keys($datos)[$ind]]);
            }
            try {
                return $this->ejecutar();
            } catch (Exception $e) {
                die("Ya existe una oferta con ese código");
            }
            
        }
        public function modificar($datos){
            $cadSQL="UPDATE t_ofertas set descripcion=:descripcion,
            fecha_limite=:fecha_limite,descuento=:descuento,dni_prof=:dni_prof 
            WHERE cod_oferta=:cod_oferta";
            $this->consultar($cadSQL);
            $this->enlazar("cod_oferta",$datos['cod_oferta']);
            $this->enlazar("descripcion",$datos['descripcion']);
            $this->enlazar("fecha_limite",$datos['fecha_limite']);
            $this->enlazar("descuento",$datos['descuento']);
            $this->enlazar("dni_prof",$datos['dni_prof']);
            return $this->ejecutar();
        }
        public function borrarOferta($cod)
    {
        $cadSQL = "DELETE FROM t_ofertas WHERE cod_oferta=:cod_oferta";
        $this->consultar($cadSQL);
        $this->enlazar(":cod_oferta", $cod);
        $this->ejecutar();
    }
        
    }
