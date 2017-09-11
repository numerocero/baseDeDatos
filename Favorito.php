<?php

use DB;
use Registro;
use Usuario;

class Favorito extends Registro
{
	public static $tabla = 'favoritos';
	
	public static $indice = ['codigousuario', 'codigousuariofavorito'];
	
	private function verificar()
	{
		if(empty($this->datos['codigousuario'])){
			throw new Exception('El codigo de usuario no puede estar vacio');
		}
		if(empty(Usuario::obtener(['codigousuario'=>$this->datos['codigousuario']]))){
			throw new Exception('El usuario no existe');
		}
		if(empty($this->datos['codigousuariofavorito'])){
			throw new Exception('El codigo de usuario favorito no puede estar vacio');
		}
		if(empty(Usuario::obtener(['codigousuario'=>$this->datos['codigousuariofavorito']]))){
			throw new Exception('El usuario favorito no existe');
		}
	}
	
	public static function listar()
	{
		$tabla = DB::all(self::$tabla);
		$resultado = [];
		foreach($tabla as $k => $datos){
			$resultado[$k] = new Favorito();
			$resultado[$k]->cargar($datos);
		}
		return $resultado;
	}
	
	public static function obtener($id)
	{
		$tabla = DB::get(self::$tabla, $id);
		$resultado = [];
		foreach($tabla as $k => $datos){
			$resultado[$k] = new Favorito();
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