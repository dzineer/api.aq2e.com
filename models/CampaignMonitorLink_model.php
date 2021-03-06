<?php

/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class CampaignMonitorLink_model extends ResourceModel {
	
	private $table_name = 'aq2emp_campaign_link_monitors';
	
    function __construct() {
        parent::__construct();
    }
    
	function get_monitor_link( $hash ) {
		
		$res = $this->db->select('
		        lm.campaign_id
			  , lm.link_id
		      , l.name
		      , l.link
		      , l.hash')
		                ->from('aq2emp_campaign_link_monitors lm')
		                ->join('aq2emp_campaign_links l', 'l.hash = lm.hash', 'inner')
		                ->where( array( 'lm.hash' => $hash ) )
		                ->get();
		
		return $res->result_array();
	}
    
    /*
     * Get all campaign_capture_links
     */
    public function get_all_monitor_links() {
    	
	    $res = $this->db->select('
		        lm.campaign_id
			  , lm.link_id
		      , l.name
		      , l.link
		      , l.hash')
	                    ->from('aq2emp_campaign_link_monitors lm')
	                    ->join('aq2emp_campaign_links l', 'l.hash = lm.hash', 'inner')
	                    ->get();
	
	    return $res->result_array();
    }
    
}
