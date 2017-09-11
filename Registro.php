<?php

abstract class Registro {
	
	public $datos;
	
	/**
	 * Constructor de la clase
	 */
	public function __construct()
	{
		$this->datos = [];
	}
	
	/**
	 * Carga los valores del Registro con los valores contenidos en $datos
	 * Cada elemento del arreglo de datos es $nombre_columna => $valor
	 *
	 * @param array
	 * @return void
	 */
	private function cargar($datos){
		foreach ($datos as $columna => $valor){
			$this->datos[$columna] = $valor;
		}
	}
	
	/**
	 * Indica si los datos del registro cumplen con las reglas de negocio
	 *
	 * @return bool
	 */
	private abstract function verificar();
	
	/**
	 * Devuelve un arreglo de Registros con todos los valores de la tabla
	 *
	 * @return array
	 */
	public abstract static function listar();
	
	/**
	 * Obtiene todos los Registros de la tabla que cumplan con las condiciones especificadas en $id
	 * Cada elemento del arreglo de condiciones es $nombre_columna => $valor y genera una condicion 'where nombre_columna = valor'
	 *
	 * @param array
	 * @return array
	 */
	public abstract static function obtener($id);
	
	/**
	 * Crea un nuevo registro en la tabla con los datos especificados en $datos
	 * Cada elemento del arreglo de datos es $nombre_columna => $valor
	 *
	 * @param array
	 * @return void
	 */
	public abstract function alta($datos);
	
	/**
	 * Elimina los registros de la tabla  que cumplan con las condiciones $id
	 * Cada elemento del arreglo de condiciones es $nombre_columna => $valor y genera una condicion 'where nombre_columna = valor'
	 *
	 * @param array
	 * @return void
	 */
	public abstract static function baja($id);
	
	/**
	 * Modifica los valores de los datos del registro especificados en $datos en la BD
	 * Los valores que no se encuentren en $datos permanecen intactos
	 * Cada elemento del arreglo de datos es $nombre_columna => $valor
	 *
	 * @param array
	 * @return void
	 */
	public abstract function modificar($datos);
	
}