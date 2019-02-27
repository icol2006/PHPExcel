<?php
class NetInfo
{
    // Declaraci�n de una propiedad
    public $codigo = '';
    public $nombreSSID='';
    public $passwordSSID='';
    public $comentario='';


	function __construct( $codigo, $nombreSSID, $passwordSSID, $comentario ) {
            $this->codigo = $codigo;
            $this->nombreSSID = $nombreSSID;
            $this->passwordSSID = $passwordSSID;
            $this->comentario = $comentario;
	}
 
	function getCodigo() {
		return $this->codigo;
	}
 
	function getNombreSSID() {
		return $this->nombreSSID;
    }
    
    function getPasswordSSID() {
		return $this->passwordSSID;
    }
    
    function getComentario() {
		return $this->comentario;
	}
}
?>
