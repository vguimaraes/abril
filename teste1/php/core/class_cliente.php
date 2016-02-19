<?php 
class Cliente{
	private $status = false;

	function __construct(){
		include_once(PATH_CORE."/class_db.php");
	}	

	
	public function novo_cliente($dados){
		$db = new DB();
		
		$res = $db->insert($dados,'cliente');
		if(empty($res['cod'])){
			if(empty($res['cod'])){
				$this->status = true;
			}
		}
		return $this->status;
	}

	public function ler_cliente($filtro = array()){
		$db = new DB();
		$campos = array('*');
		$filtro = (count($filtro)>0)?$filtro:null;

		$res = $db->select($campos,'cliente',$filtro);
		return $res;
	}

	
}