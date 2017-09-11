<?php

use DB;
use Registro;
use Usuario;
use Pago;

class UsuarioPago extends Registro
{
	public static $tabla = 'usuariospagos';
	
	public static $indice = ['codigopago', 'codigousuario'];
	
	private function verificar()
	{
		if(empty($this->datos['codigopago'])){
			throw new Exception('El codigo de pago no puede estar vacio');
		}
		if(empty(Usuario::obtener(['codigopago'=>$this->datos['codigopago']]))){
			throw new Exception('El pago no existe');
		}
		if(empty($this->datos['codigousuario'])){
			throw new Exception('El codigo de usuario no puede estar vacio');
		}
		if(empty(Usuario::obtener(['codigousuario'=>$this->datos['codigousuario']]))){
			throw new Exception('El usuario no existe');
		}
	}
	
	public static function listar()
	{
		$tabla = DB::all(self::$tabla);
		$resultado = [];
		foreach($tabla as $k => $datos){
			$resultado[$k] = new UsuarioPago();
			$resultado[$k]->cargar($datos);
		}
		return $resultado;
	}
	
	public static function obtener($id)
	{
		$tabla = DB::get(self::$tabla, $id);
		$resultado = [];
		foreach($tabla as $k => $datos){
			$resultado[$k] = new UsuarioPago();
			$resultado[$k]->cargar($datos);
		}
		return $resultado;
	}
	
	public function alta($datos)
	{
		$this->cargar($datos);
		$this->verificar();
		DB::save($this);
	}
	
	public static function baja($id)
	{
		DB::transaccion(function(){
			DB::delete(self::$tabla, $id);
		});
	}
	
	public function modificar($datos)
	{
		$anterior = $this->datos;
		$this->cargar($datos);
		$this->verificar();
		DB::update($this, $anterior);
	}
}