<?php
/**
 * Filename: WebhookActionsReport_model.php
 * Project: api.aq2e.local
 * Editor: PhpStorm
 * Namespace: ${NAMESPACE}
 * Class:
 * Type:
 *
 * @author: Frank Decker
 * @since : 6/1/2017 11:58 PM
 */
//require_once('');

class WebhookActionsReport_model extends ResourceModel {
	
	/* variables */
	/* constants */
	
	function __construct() {
		parent::__construct();
	}
	
	function __destruct() {
	}

	function get_report( $id ) {
		
		$res = $this->db->select('
                war.id
              , war.subscriber_id
              , war.data
              , war.registered_action_id
              , war.created_at
              , ra.id
              , ra.name
			  , a.id as action_id
			  , a.name as action
			  , at.entity
      
        ')
        ->from('aq2emp_webhook_actions_report war')
        ->join('aq2emp_registered_actions ra', 'ra.id = war.registered_action_id', 'inner')
        ->join('aq2emp_actions a', 'ra.action_id = a.id', 'inner')
        ->join('aq2emp_action_types at', 'at.id = a.action_type_id', 'inner')
        ->where( array( 'war.id =' => intval($id) ) )
        ->get();
		
		$res = $res->result_array();
		
		return $res;
	}
	
	function get_all_reports() {
		
		$res = $this->db->select('
                war.id
              , war.subscriber_id
              , war.data
              , war.registered_action_id
              , war.created_at
              , ra.id
              , ra.name
			  , a.id as action_id
			  , a.name as action
			  , at.entity
      
        ')
        ->from('aq2emp_webhook_actions_report war')
        ->join('aq2emp_registered_actions ra', 'ra.id = war.registered_action_id', 'inner')
        ->join('aq2emp_actions a', 'ra.action_id = a.id', 'inner')
        ->join('aq2emp_action_types at', 'at.id = a.action_type_id', 'inner')
        ->get();
		
		$res = $res->result_array();
		
		return $res;
	}
	
   /*
    * function to add new aq2emp_webhook_actions_report
    */
	function add_report($params) {
		$this->db->insert('aq2emp_webhook_actions_report',$params);
		return $this->db->insert_id();
	}
	
	
	/*
	 * function to delete aq2emp_webhook_actions_report
	 */
	function delete_report($id)
	{
		$response = $this->db->delete('aq2emp_webhook_actions_report',array('id'=>$id));
		if($response)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
} // end of WebhookActionsReport_model