<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OrcamentoEquipamentos extends CI_Model {

	public $query;
	public $database = 'orcamento_equipamento';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
		$this->query = $this->db->get($this->database);
	}
	
	public function add($equipamentos,$id)
	{
		foreach ($equipamentos as $linha)
		{
			$data = array(
				'idOrcamento' => $id,
				'idEquipamento' => $linha['id'],
				'valordiaria' => $linha['valordiaria'],
				'dataentrada' => $this->date_br_to_default($linha['dataentrada']),
				'datasaida' => $this->date_br_to_default($linha['datasaida'])
				);
			$this->db->insert($this->database, $data);
		}
	}
	
	public function update($equipamentos,$id)
	{
		$this->delete($id);
		$this->add($equipamentos,$id);
	}
	
	
	public function getAll()
	{	
		return $this->query->result_array();
	}
	
	public function getById($id=null)
	{
		$query= $this->db->get_where($this->database, array('id =' => $id))->result_array();
		return $query[0];
	}

	public function getByIdOrc($id=null)
	{
		$query= $this->db->get_where($this->database, array('idOrcamento =' => $id))->result_array();
		return $query;
	}


	public function count()
	{
		return $this->db->count_all($this->database);
	}
	
	public function date_br_to_default($date)
	{
		list($dia, $mes, $ano) = explode ('/', $date);
		$newDate = "$ano-$mes-$dia";
		return $newDate;
	}
	
	public function date_default_to_br($date)
	{
		list($ano, $mes, $dia) = explode ('-', $date);
		$newDate = "$dia/$mes/$ano";
		return $newDate;
	}
	
	public function delete($id)
	{
		$this->db->delete($this->database, array('idOrcamento' => $id));
	}

}

/* End of file orcamentoequipamentos.php */
/* Location: ./application/models/orcamentoequipamentos.php */
?>