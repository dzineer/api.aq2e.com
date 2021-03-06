<?php

/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class CampaignCaptureLink_model extends ResourceModel {
	
    function __construct() {
        parent::__construct();
    }
    
    /*
     * Get campaign_capture_links by id
     */
    function get_campaign_capture_link($id) {
	
	    $res = $this->db->select('
                cl.id
			  , cl.campaign_id
			  , cl.page_form_id
			  , cl.form_id
			  , cr.id as rule_id
			  , cr.name
			  , cr.capture_link_id ')
	                          ->from('aq2emp_campaign_capture_links cl')
	                          ->join('aq2emp_campaign_rules cr', 'cr.capture_link_id = cl.id', 'inner')
	                          ->where( array( 'cl.id' => intval($id) ) )
	                          ->get();
	
	    return $res->result_array();
    }
	
	function get_campaign_capture_link_rules($id) {
		
		$res = $this->db->select('
		        cl.page_form_id
			  , cr.id as rule_id
			  , cr.name
			  , cr.capture_link_id ')
		                ->from('aq2emp_campaign_capture_links cl')
		                ->join('aq2emp_campaign_rules cr', 'cr.capture_link_id = cl.id', 'inner')
		                ->where( array( 'cl.id' => intval($id) ) )
		                ->get();
		
		return $res->result_array();
	}
    
    /*
     * Get all campaign_capture_links
     */
    function get_all_campaign_capture_links() {
        return $this->db->get('aq2emp_campaign_capture_links')->result_array();
    }
    
    /*
     * function to add new aq2emp_campaign_capture_link
     */
    function add_campaign_capture_link($params)
    {
        $this->db->insert('aq2emp_campaign_capture_links',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update campaign_forms_page
     */
    function update_campaign_capture_link($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('aq2emp_campaign_capture_links',$params);
        if($response)
        {
            return "campaign_capture_links updated successfully";
        }
        else
        {
            return "Error occurring while updating campaign_capture_links";
        }
    }
    
    /*
     * function to delete campaign_capture_link
     */
    function delete_campaign_capture_link($id)
    {
        $response = $this->db->delete('aq2emp_campaign_forms_page',array('id'=>$id));
        if($response)
        {
            return "campaign_capture_links deleted successfully";
        }
        else
        {
            return "Error occurring while deleting campaign_capture_links";
        }
    }
}
