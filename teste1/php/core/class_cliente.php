<?php 
class Cliente{
	private $status = false;

	function __construct(){
		include_once(PATH_CORE."/class_db.php");
	}	

	
	public function novo_cliente($dados){
		$db = new DB();
		unset($dados['mod']);
		unset($dados['sub']);
		unset($dados['act']);
		unset($dados['id']);
		
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
		$filtro['ativo']=1;
		
		$res = $db->select($campos,'cliente',$filtro);
		return $res;
	}

	public function remover_cliente($id=null){
		if(!is_null($id)){
			$db = new DB();
			$res = $db->delete('cliente',array('id'=>$id));
		}

	}

	public function atualizar_cliente($dados){
		$db = new DB();

		$id = $dados['id'];
		unset($dados['mod']);
		unset($dados['sub']);
		unset($dados['act']);
		unset($dados['id']);

		$res = $db->update($dados,'cliente',array('id'=>$id));
	}

	
}