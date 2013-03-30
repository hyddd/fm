<?php 
class Base_model extends CI_Model {

	var $operators = array(
			'eq'=>array('op'=>' = ', 'or_func'=>'or_where', 'and_func'=>'where', ),
			'ne'=>array('op'=>' != ', 'or_func'=>'or_where', 'and_func'=>'where', ),
			'lt'=>array('op'=>' < ', 'or_func'=>'or_where', 'and_func'=>'where', ),
			'le'=>array('op'=>' <= ', 'or_func'=>'or_where', 'and_func'=>'where', ),
			'gt'=>array('op'=>' > ', 'or_func'=>'or_where', 'and_func'=>'where', ),
			'ge'=>array('op'=>' >= ', 'or_func'=>'or_where', 'and_func'=>'where', ),
			'in'=>array('op'=>null, 'or_func'=>'or_where_in', 'and_func'=>'where_in', ),																			// in
			'ni'=>array('op'=>null, 'or_func'=>'or_where_not_in', 'and_func'=>'where_not_in', ),															// not in
			'bw'=>array('op'=>null, 'or_func'=>'or_like', 'and_func'=>'like', 'is_like'=>true, 'like_flag'=>'after'),																// begin with
			'bn'=>array('op'=>null, 'or_func'=>'or_not_like', 'and_func'=>'not_like', 'is_like'=>true, 'like_flag'=>'after'),												// not begin with
			'ew'=>array('op'=>null, 'or_func'=>'or_like', 'and_func'=>'like', 'is_like'=>true, 'like_flag'=>'before'),															// end with
			'en'=>array('op'=>null, 'or_func'=>'or_not_like', 'and_func'=>'not_like', 'is_like'=>true, 'like_flag'=>'before'),											// not end with
			'cn'=>array('op'=>null, 'or_func'=>'or_like', 'and_func'=>'like', 'is_like'=>true, 'like_flag'=>'both'),																// contains
			'nc'=>array('op'=>null, 'or_func'=>'or_not_like', 'and_func'=>'not_like', 'is_like'=>true, 'like_flag'=>'both'),												// not contains
	);
	
	function __construct(){
		parent::__construct();
	}

	public function get($filters=null, $fields='*'){
		$this->load->database();
		
		if( is_array($fields)){
			$fields = implode(',', $fields);
		}
		$this->db->select($fields);
		
		if( ! empty($filters)){
			$this->db->where($filters);
		}
		
		$query = $this->db->get($this->tableName);
		$result = $query->result_array();

		return $result;
	}
	
	public function getOne($filters=null, $fields='*'){
		$this->load->database();
		
		if( is_array($fields)){
			$fields = implode(',', $fields);
		}
		$this->db->select($fields);
		
		if( ! empty($filters)){
			$this->db->where($filters);
		}
		
		$this->db->limit(1);
		
		$query = $this->db->get($this->tableName);
		$result = $query->row_array();

		return $result;
	}
	
	public function insert($data){
		$this->load->database();
		
		$this->db->insert($this->tableName, $data);
		return $this->db->insert_id();
	}
	
	public function update($data, $where=null){
		$this->load->database();
		
		if( ! empty($where)){
			$this->db->where($where);
		}
		
		$this->db->update($this->tableName, $data);
		return $this->db->affected_rows() ? true : false;
	}
	
	public function getById($id, $fields='*'){
		$this->load->database();
		
		$this->db->select($fields);
		$this->db->where($this->primaryKey, $id);
		$query = $this->db->get($this->tableName);
		
		return $query->row_array();
	}
	
	function getPage($pageno=1, $pagesize=20, $filters=null, $sorts=null){
		$limit = $pagesize;
		$offset = ($pageno-1) * $pagesize;
			
		$this->load->database();
	
		// filters : {"groupOp":"AND","rules":[{"field":"isFixed","op":"eq","data":"1"},{"field":"fixTime","op":"lt","data":""},{"field":"alarmType","op":"eq","data":"1"}]}
		if( ! empty($filters)){
			foreach($filters['rules'] as $rule){
				if( ! isset($this->operators[$rule['op']])){
					continue;
				}
	
				$op = $this->operators[$rule['op']];
	
				// set where
				$field = $op['op'] ? $rule['field'] . $op['op'] : $rule['field'];
				$value = $rule['data'];
	
				if( strtolower($filters['groupOp']) == 'and' ){
					if( isset($op['is_like']) && $op['is_like']){
						$this->db->$op['and_func']($field, $value, $op['like_flag']);
					}else{
						$this->db->$op['and_func']($field, $value);
					}
				}else if( strtolower($filters['groupOp']) == 'or' ){
					if( isset($op['is_like']) && $op['is_like']){
						$this->db->$op['or_func']($field, $value, $op['like_flag']);
					}else{
						$this->db->$op['or_func']($field, $value);
					}
				}
			}
		}
	
		// sort : [{"sidx": "isFixed", "sord": "desc"}, {"sidx": "fixTime", "sord": "desc"}]
		$sorts = ( empty($sorts) && isset($this->defaultSort) ) ? $this->defaultSort : $sorts;
		if( ! empty($sorts)){
			foreach($sorts as $sort){
				$this->db->order_by($sort['sidx'], $sort['sord']);
			}
		}
	
		$query = $this->db->get($this->tableName, $limit, $offset);
		$results = $query->result_array();
		
		if( ! empty($filters)){
			foreach($filters['rules'] as $rule){
				if( ! isset($this->operators[$rule['op']])){
					continue;
				}
		
				$op = $this->operators[$rule['op']];
		
				// set where
				$field = $op['op'] ? $rule['field'] . $op['op'] : $rule['field'];
				$value = $rule['data'];
		
				if( strtolower($filters['groupOp']) == 'and' ){
					if( isset($op['is_like']) && $op['is_like']){
						$this->db->$op['and_func']($field, $value, $op['like_flag']);
					}else{
						$this->db->$op['and_func']($field, $value);
					}
				}else if( strtolower($filters['groupOp']) == 'or' ){
					if( isset($op['is_like']) && $op['is_like']){
						$this->db->$op['or_func']($field, $value, $op['like_flag']);
					}else{
						$this->db->$op['or_func']($field, $value);
					}
				}
			}
		}
		$total = $this->db->count_all_results($this->tableName);
		$totalPage = ($total % $pagesize == 0) ? $total / $pagesize : (int)($total / $pagesize)+1;
	
		$page = array(
				'total'=>$total,
				'totalPage'=>$totalPage,
				'pageno'=>$pageno,
				'pagesize'=>$pagesize,
				'rows'=>$results,
		);
		
		$page = $this->pageFormatter($page);
		return $page;
	}
	
	public function pageFormatter($page){
		return $page;
	}
}
