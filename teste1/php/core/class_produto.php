<?php 
class Produto{
	private $status = false;

	function __construct(){
		include_once(PATH_CORE."/class_db.php");
	}	

	
	public function novo_pedido($dados){
		$db = new DB();
		
		$res = $db->insert($dados,'pedido');
		if(empty($res['cod'])){
			if(empty($res['cod'])){
				$filtro = array('id'=>$dados['id_produto']);
				$produto = $this->ler_produto($filtro);
				$estoque = ($produto['retorno'][0]['estoque']-1);

				$db->update(
						array('estoque'=>$estoque),
						'produto',
						array('id'=>$dados['id_produto'])
					);

				$this->status = true;
			}
		}
		return $this->status;
	}

	public function ler_produto($filtro = array()){
		$db = new DB();
		$campos = array('*');
		$filtro = (count($filtro)>0)?$filtro:null;

		$res = $db->select($campos,'produto',$filtro);
		return $res;
	}

	public function ler_pedido($filtro = array()){
		$db = new DB();
		$campos = array('*');
		$filtro = (count($filtro)>0)?$filtro:null;

		$res = $db->select($campos,'v_pedidos',$filtro);
		return $res;
	}
}