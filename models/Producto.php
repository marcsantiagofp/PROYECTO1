<?php
        class Producto{

                protected $id;
                protected $nombre;
                protected $precio;
                protected $url_imagen;
                protected $descripcion;
                protected $id_categoria;

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

                /**
                 * Get the value of descripcion
                 */ 
                public function getDescripcion()
                {
                                return $this->descripcion;
                }

                /**
                 * Set the value of descripcion
                 *
                 * @return  self
                 */ 
                public function setDescripcion($descripcion)
                {
                                $this->descripcion = $descripcion;

                                return $this;
                }

                /**
                 * Get the value of id
                 */ 
                public function getId()
                {
                                return $this->id;
                }

                /**
                 * Set the value of id
                 *
                 * @return  self
                 */ 
                public function setId($id)
                {
                                $this->id = $id;

                                return $this;
                }

                /**
                 * Get the value of id_categoria
                 */ 
                public function getId_categoria()
                {
                                return $this->id_categoria;
                }

                /**
                 * Set the value of id_categoria
                 *
                 * @return  self
                 */ 
                public function setId_categoria($id_categoria)
                {
                                $this->id_categoria = $id_categoria;

                                return $this;
                }
        }
?>