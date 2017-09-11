<?php

abstract class DB
{
	/**
	 * Devuelve todos los registros de la tabla especificada en el parametro $tabla como arreglos indexados
	 *
	 * @param string 
	 * @return array
	 */
	abstract public static function all($tabla);
	
	/**
	 * Devuelve los registros de la tabla especificada en el parametro $tabla que cumplan con las codiciones especificadas en el parametro $condiciones
	 * Cada elemento del arreglo de condiciones es $nombre_columna => $valor y genera una condicion 'where nombre_columna = valor'
	 * 
	 * @param string $tabla
	 * @param array $condiciones
	 * @return array
	 */
	abstract public static function get($tabla, $condiciones);
	
	/**
	 * Guarda en la DB un registro y devuelve el id del registro generado si la tabla tiene un id simple (no compuesto) o null en caso contrario
	 *
	 * @param Registro
	 * @return mixed
	 */
	abstract public static function save($registro);
	
	/**
	 * Actualiza los datos del registro especificado por $condiciones en la tabla $tabla
	 * Cada elemento del arreglo de condiciones es $nombre_columna => $valor y genera una condicion 'where nombre_columna = valor'
	 *
	 * @param string
	 * @param array
	 * @param array
	 * @return void
	 */
	abstract public static function update($tabla, $datos, $condiciones);
	
	/**
	 * Elimina un registro de $tabla especificado por $condiciones
	 * Cada elemento del arreglo de condiciones es $nombre_columna => $valor y genera una condicion 'where nombre_columna = valor'
	 *
	 * @param string
	 * @param array
	 * @return void
	 */
	abstract public static function delete($tabla, $condiciones);
	
	/**
	 * Envuelve las operaciones contenidas en $query en una transaccion de BD, sis se presenta una excepcion se hace rollback de las operaciones
	 * si no hay ningun error se hace un commit de las operaciones
	 *
	 * @param Closure
	 * @return void
	 */
	abstract public static function transaccion($query);
}