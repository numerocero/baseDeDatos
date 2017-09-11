<?php

use DB;
use Registro;
use Favoritos;
use UsuariosPagos

class Usuario extends Registro
{
	public static $tabla = 'usuarios';
	
	public static $indice = 'codigousuario';

	private function verificar()
	{
		if(empty($this->datos['usuario'])){
			throw new Exception('El nombre de usuario no puede estar vacio');
		}
		if(empty($this->datos['edad']) || $this->datos['edad']<18){
			throw new Exception('La edad no puede ser menor a 18 años');
		}
	}
	
	public static function listar()
	{
		$tabla = DB::all(self::$tabla);
		$resultado = [];
		foreach($tabla as $k => $datos){
			$resultado[$k] = new Usuario();
			$resultado[$k]->cargar($datos);
		}
		return $resultado;
	}
	
	public static function obtener($id)
	{
		$tabla = DB::get(self::$tabla, $id);
		$resultado = [];
		foreach($tabla as $k => $datos){
			$resultado[$k] = new Usuario();
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
			//$id = ['codigousuario'=>$this->datos['id']];
			Favoritos::baja($id);
			UsuariosPagos::baja($id);
			DB::delete(self::$tabla, $id);
		});
	}
	
	public function modificar($datos)
	{
		$this->cargar($datos);
		$this->verificar();
		DB::update($this, ['codigousuario'=>$this->datos['codigousuario']]);
	}
}