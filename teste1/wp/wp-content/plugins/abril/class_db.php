<?php
class DB {
	
	private $ambiente = 'producao';
	private $host;
	private $user;
	private $pass;
	private $base;
	
	private $query;
	private $link;
	private $result = array();
	
	private $int = array('integer','boolean','double');
	
	function __construct(){
		switch($this->ambiente){
			case 'producao':
				$this->host='localhost';
				$this->user='root';
				$this->pass='admin';
				$this->base='abril';
			break;
			default://Localhost
				$this->host='localhost';
				$this->user='root';
				$this->pass='admin';
				$this->base='dev';
			break;
		}
		$this->connect();
	}
	
	
	private function connect(){
		$this->link = @mysql_connect($this->host,$this->user,$this->pass);
		if(!$this->link){
			echo mysql_error();
			die();
		}elseif(!mysql_select_db($this->base,$this->link)){
			echo mysql_error();
			die();
		}
	}
	
	
	public function query($query){
		$this->query = $query;
		if(!$this->result=mysql_query($this->query)){
			$return = array(
				'cod'=>mysql_errno(),
				'mysql'=>mysql_error(),
				'linhas'=>mysql_affected_rows(),
				'query'=>$this->query,
				'retorno'=>$this->msg(mysql_errno())
			);
			$this->result = $return;
			return $this->result;
			die();
			$this->disconnect();
		}else{
			if(substr($query,0,5)=='INSER'||substr($query,0,5)=='DELET'||substr($query,0,5)=='UPDAT'){
				$return = array(
						'cod'=>null,
						'mysql'=>null,
						'linhas'=>mysql_affected_rows(),
						'query'=>$this->query,
						'retorno'=>mysql_insert_id()
				);
				$this->result = $return;
			}else{
				$totalCampos = mysql_num_fields($this->result);
				$tabela = array();
				while($a=mysql_fetch_array($this->result)){
					for($i=0;$i<$totalCampos;$i++){
						$campo=mysql_field_name($this->result, $i);
						$linha[$campo]=utf8_encode($a[$campo]);
					}
					array_push($tabela, $linha);
				}
				$return = array(
						'cod'=>null,
						'mysql'=>null,
						'linhas'=>mysql_affected_rows(),
						'query'=>$this->query,
						'retorno'=>$tabela
				);
				$this->result = $return;
			}
			return $this->result;
			$this->disconnect();
		}
	}
	
	/*
	 * Realiza SELECT  na base de dados
	 */
	public function select($dados, $tabela,$filtro=null,$orderby=null,$limite=null,$groupby=null){
		$cont=0;
		$query = "SELECT ";
		foreach ($dados as $valor){
			if(!is_array($valor)){
				$cont++;
				$query .= $this->slashes($valor);
				if($cont<count($dados)){
					$query .=', ';
				}
			}
		}
		$query .= " FROM ".$tabela." ";
		if(!is_null($filtro)){
			$query .= ' WHERE ';
			
			if(isset($filtro['like'])){
				$add = 0;
				foreach ($filtro['like'] as $keyFiltro =>$filtroVal){
					$add++;
					$query .=$keyFiltro.' LIKE "%'.$filtroVal.'%"';
					if($add<count($filtro['like'])){
						$query .= ' AND ';
					}
				}
				unset($filtro['like']);
				if(count($filtro)>0){
					$query .= ' AND ';
				}
			}
			if(isset($filtro['between'])){
				if(!is_null($filtro['between']['inicio'])&&!is_null($filtro['between']['fim'])){
					$query .=$filtro['between']['campo'].' BETWEEN ';
					$query .=$filtro['between']['inicio'].' AND '.$filtro['between']['fim'];
					if(count($filtro)>0){
						$query .= ' AND ';
					}
				}
				unset($filtro['between']);
			}
			
			$add = 0;
			foreach ($filtro as $keyFiltro =>$filtroVal){
				$add++;
				$query .=$keyFiltro.'=';
				$query .=(in_array(gettype($filtroVal),$this->int))?$filtroVal:"'".$this->slashes($filtroVal)."'";
				if($add<count($filtro)){
					$query .= ' AND ';
				}
			}						
		}
		if(!is_null($groupby)){
			$query .= ' GROUP BY ';
			$query .= $groupby.' ';
		}
		
		if(!is_null($orderby)){
			$query .= ' ORDER BY ';
			$query .= $orderby['campo'].' ';//array('campo1, campo2','asc')
			$query .= $orderby['ordem'];
		}
		
		if(!is_null($limite)){
			$query .= ' LIMIT '.$limite['offSet'].', '.$limite['limite'];
		}
		$result = $this->query($query);
		return $result;
	}
	
	public function selectFullText($dados, $tabela,$colunasIdx,$buscaIdx,$filtro=null,$orderby=null,$limite=null){
		$cont=0;
		$query = "SELECT ";
		foreach ($dados as $valor){
			if(!is_array($valor)){
				$cont++;
				$query .= $this->slashes($valor);
				if($cont<count($dados)){
					$query .=', ';
				}
			}
		}
		$query .= " FROM ".$tabela." ";
		$query .= ' WHERE MATCH(';
		$add = 0;
		foreach ($colunas as $coluna){
			$add++;
			$query .= $coluna;
			if($add<count($colunas)){
				$query .= ', ';
			}
		}
		$query .= ') AGAINST ("'.$busca.'" IN BOOLEAN MODE)';
				
		if(!is_null($filtro)){
			$query .= ' AND ';
			$add = 0;
			foreach ($filtro as $keyFiltro =>$filtroVal){
				$add++;
				$query .=$keyFiltro.'=';
				$query .=(in_array(gettype($filtroVal),$this->int))?$filtroVal:"'".$this->slashes($filtroVal)."'";
				if($add<count($filtro)){
					$query .= ' AND ';
				}
			}
		}
		
		if(!is_null($orderby)){
			$query .= ' ORDER BY ';
			$query .= $orderby['campo'].' ';//array('campo1, campo2','asc')
			$query .= $orderby['ordem'];
		}
	
		if(!is_null($limite)){
			$query .= ' LIMIT '.$limite['offSet'].', '.$limite['limite'];
		}
		$result = $this->query($query);
		return $result;
	}
	
	/*
	 * Realiza INSERT na base de dados
	 */
	public function insert($dados,$tabela){
		
		$cont=0;
		$query = "INSERT INTO ".$tabela." SET ";
		foreach ($dados as $coluna=> $valor){
			if(!is_array($valor) && !is_null($valor)){
				$cont++;
				$query .= $coluna;
				$query .= (in_array(gettype($valor),$this->int))?"=".$valor:"='".$this->slashes($valor)."'";
				if($cont<count($dados)){
					$query .=', ';
				}
			}
		}

		$result = $this->query($query);
		return $result;
	}
	
	/*
	 * Realiza UPDATE no banco de dados
	 */
	public function update($dados,$tabela,$filtro=null){
	
		$cont=0;
		$query = "UPDATE ".$tabela." SET ";
		foreach ($dados as $coluna=> $valor){
			if(!is_array($valor) && !is_null($valor)){
				$cont++;
				$query .= $coluna;
				$query .= (in_array(gettype($valor),$this->int))?"=".$valor:"='".$this->slashes($valor)."'";
				if($cont<count($dados)){
					$query .=', ';
				}
			}
		}
		if(!is_null($filtro)){
			$query .= ' WHERE ';
			$add = 0;
			foreach ($filtro as $keyFiltro =>$filtroVal){
				$add++;
				$query .=$keyFiltro.'=';
				$query .=(in_array(gettype($filtroVal),$this->int))?$filtroVal:"'".$this->slashes($filtroVal)."'";
				if($add<count($filtro)){
					$query .= ' AND ';
				}
			}
		}
	
		$result = $this->query($query);
		return $result;
	}
	
	
	public function delete($tabela,$filtro=null){
	
		$query = "DELETE FROM ".$tabela;
		
		if(!is_null($filtro)){
			$query .= ' WHERE ';
			$add = 0;
			foreach ($filtro as $keyFiltro =>$filtroVal){
				$add++;
				$query .=$keyFiltro.'=';
				$query .=(in_array(gettype($filtroVal),$this->int))?$filtroVal:"'".$this->slashes($filtroVal)."'";
				if($add<count($filtro)){
					$query .= ' AND ';
				}
			}
		}
	
		$result = $this->query($query);
		return $result;
	}
	
	public function bulk($dados,$tabela){
		
		$valores = '';
		$contLin = 0;
		foreach ($dados as $linha){
			$contLin++;
			$contVal = 0;
			$valores .= '(';
			foreach ($linha as $coluna => $valor){
				$contVal++;
				$colunas[$coluna]=$coluna;
				$valores .= (in_array(gettype($valor),$this->int))?$valor:"'".$this->slashes($valor)."'";
				if($contVal< count($linha)){
					$valores .=', ';
				}
			}
			$valores .= ')';
			if($contLin<count($dados)){
				$valores .=', ';
			}
		}
		
		$query = 'INSERT INTO '.$tabela.' (';
		$contCol = 0;
		foreach ($colunas as $col){
			$contCol++;
			$query .= $col;
			if($contCol<count($colunas)){
				$query .=', ';
			}
		}
		$query .= ') VALUES '.$valores;
		$result = $this->query($query);
		return $result;
	}
	
	private function disconnect(){
		return mysql_close($this->link);
	}

	private function slashes($str){
		$str = trim(addslashes($str));
		return $str;
	}
	private function msg($erroCod){
		switch ($erroCod){
			case 1062:$return="Cadastro já existe no sistema";break;
			case 1064:$return="Problema na sitaxe SQL";break;
			case 1054:$return="Uma ou mais colunas informadas na busca não existem";break;
			default: $return = "Erro SQL não mapeado";break;
		}
		return  $return;
	}
}

?>
