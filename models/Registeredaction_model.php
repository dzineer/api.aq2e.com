<?php

class Registeredaction_model extends ResourceModel {

	function __construct()
	{
	    parent::__construct();
	}

	function get_registered_action( $id ) {
		
		$res = $this->db->select('
                ra.id
              , ra.name
			  , a.id as action_id
			  , a.name as action
			  , at.entity
      
        ')
        ->from('aq2emp_registered_actions ra')
        ->join('aq2emp_actions a', 'ra.action_id = a.id', 'inner')
        ->join('aq2emp_action_types at', 'at.id = a.action_type_id', 'inner')
        ->where( array( 'ra.id =' => intval($id) ) )
        ->get();
		
		$res = $res->result_array();
		
		return $res;
	}
	
	function get_registered_actions() {
		
		$res = $this->db->select('
				ra.id
              , ra.name
			  , a.id as action_id
			  , a.name as action
			  , at.entity
      
        ')
        ->from('aq2emp_registered_actions ra')
        ->join('aq2emp_actions a', 'ra.action_id = a.id', 'inner')
        ->join('aq2emp_action_types at', 'at.id = a.action_type_id', 'inner')
        ->get();
		
		$res = $res->result_array();
		
		return $res;
		
	}
	
}
?>