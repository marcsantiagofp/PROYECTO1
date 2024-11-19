<?php
        class Producto{

                protected $id;
                protected $nombre;
                protected $precio;
                protected $url_imagen;

                // public function __construct($nombre,$categoria,$precio,$id_oferta,$url_imagen){
                //     $this->nombre=$nombre;
                //     $this->categoria=$categoria;
                //     $this->precio=$precio;
                //     $this->id_oferta=$id_oferta;
                //     $this->url_imagen=$url_imagen;
                // }


                /**
                 * Get the value of nombre
                 */ 
                public function getNombre()
                {
                        return $this->nombre;
                }

                /**
                 * Set the value of nombre
                 *
                 * @return  self
                 */ 
                public function setNombre($nombre)
                {
                        $this->nombre = $nombre;

                        return $this;
                }

                /**
                 * Get the value of precio
                 */ 
                public function getPrecio()
                {
                        return $this->precio;
                }

                /**
                 * Set the value of precio
                 *
                 * @return  self
                 */ 
                public function setPrecio($precio)
                {
                        $this->precio = $precio;

                        return $this;
                }
                
                /**
                 * Get the value of url_imagen
                 */ 
                public function getUrl_imagen()
                {
                        return $this->url_imagen;
                }

                /**
                 * Set the value of url_imagen
                 *
                 * @return  self
                 */ 
                public function setUrl_imagen($url_imagen)
                {
                        $this->url_imagen = $url_imagen;

                        return $this;
                }
        }
?>