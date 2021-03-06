<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class CampaignEvent_model extends ResourceModel
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get campaign_event by id
     */
    function get_campaign_event($id)
    {
        return $this->db->get_where('aq2emp_campaign_events',array('id'=>intval($id)))->row_array();
    }
    
    /*
     * Get all campaign_events
     */
    function get_all_campaign_events()
    {
        return $this->db->get('aq2emp_campaign_events')->result_array();
    }
    
    /*
     * function to add new campaign_event
     */
    function add_campaign_event($params)
    {
        $this->db->insert('aq2emp_campaign_events',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update campaign_event
     */
    function update_campaign_event($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('aq2emp_campaign_events',$params);
        if($response)
        {
            return "campaign_event updated successfully";
        }
        else
        {
            return "Error occuring while updating campaign_event";
        }
    }
    
    /*
     * function to delete campaign_event
     */
    function delete_campaign_event($id)
    {
        $response = $this->db->delete('aq2emp_campaign_events',array('id'=>$id));
        if($response)
        {
            return "campaign_event deleted successfully";
        }
        else
        {
            return "Error occuring while deleting campaign_event";
        }
    }
}
