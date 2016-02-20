<?php 
class Produto{
	private $status = false;

	function __construct(){
		include_once(PATH_CORE."/class_db.php");
	}	

	
	public function novo_pedido($dados){
		$db = new DB();

		$filtro = array('id'=>$dados['id_produto']);
		$produto = $this->ler_produto($filtro);
		$estoque = $produto['retorno'][0]['estoque'];
		if($estoque>=$dados['qtd']){
			$estoque = $estoque-$dados['qtd'];
			unset($dados['qtd']);
			$res = $db->insert($dados,'pedido');
			if(empty($res['cod'])){
				if(empty($res['cod'])){
					$res = $db->update(
							array('estoque'=>$estoque),
							'produto',
							array('id'=>$dados['id_produto'])
						);
					print_r($res);
					$this->status['executado'] = true;
					$this->status['msg'] = 'Pedido Efetuado!';
				}
			}
		}else{
			$this->status['executado'] = false;
			$this->status['msg'] = 'Produto esgotado!';
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

	public function adicionar_produto($dados){
		$db = new DB();
		unset($dados['mod']);
		unset($dados['sub']);
		unset($dados['act']);
		$res = $db->insert($dados,"produto");
	}

	public function remover_produto($id=null){
		if(!is_null($id)){
			$db = new DB();
			$res = $db->delete('produto',array('id'=>$id));
		}

	}

	public function atualizar_produto($dados){
		$db = new DB();

		$id = $dados['id'];
		unset($dados['mod']);
		unset($dados['sub']);
		unset($dados['act']);
		unset($dados['id']);

		$res = $db->update($dados,'produto',array('id'=>$id));
	}
}