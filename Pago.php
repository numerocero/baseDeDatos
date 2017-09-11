<?php

use DB;
use Registro;
use UsuariosPagos

class Pago extends Registro{
	
	public static $tabla = 'pagos';
	
	public static $indice = 'codigopago';

	private function verificar()
	{
		if(empty($this->datos['importe']) || $this->datos['importe']==0){
			throw new Exception('El importe debe ser mayor a 0');
		}
		if(empty($this->datos['fecha'])){
			throw new Exception('La fecha no puede estar vacía');
		}
		if(date_create_from_format('Y-m-d')>date()){
			throw new Exception('La fecha no pude ser mayor a la fecha actual');
		}
		
	}
	
	public static function listar()
	{
		$tabla = DB::all(self::$tabla);
		$resultado = [];
		foreach($tabla as $k => $datos){
			$resultado[$k] = new Pago();
			$resultado[$k]->cargar($datos);
		}
		return $resultado;
	}
	
	public static function obtener($id)
	{
		$tabla = DB::get(self::$tabla, $id);
		$resultado = [];
		foreach($tabla as $k => $datos){
			$resultado[$k] = new Pago();
			$resultado[$k]->cargar($datos);
		}
		return $resultado;
	}
	
	public function alta($datos)
	{
		$this->cargar($datos);
		$this->verificar();
		$this->datos[self::$indice] = DB::save($this);
	}
	
	public static function baja($id)
	{
		DB::transaccion(function(){
			UsuariosPagos::baja($id);
			DB::delete(self::$tabla, $id);
		});
	}
	
	public function modificar($datos)
	{
		$this->cargar($datos);
		$this->verificar();
		DB::update($this, ['codigopago'=>$this->datos['codigopago']]);
	}
}