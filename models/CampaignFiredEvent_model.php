<?php

 
class CampaignFiredEvent_model extends ResourceModel
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get event by id
     */
    function get_fired_event($id)
    {
        return $this->db->get_where('aq2emp_campaign_fired_events',array('id'=>intval($id)))->row_array();
    }
    
    /*
     * Get all events
     */
    function get_all_fired_events()
    {
        return $this->db->get('aq2emp_campaign_fired_events')->result_array();
    }
    
    /*
     * function to add new event
     */
    function add_fired_event($params)
    {
        $this->db->insert('aq2emp_campaign_fired_events',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update event
     */
    function update_fired_event($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('aq2emp_campaign_fired_events',$params);
        if($response)
        {
            return "fired event updated successfully";
        }
        else
        {
            return "Error occuring while updating fired event";
        }
    }
    
    /*
     * function to delete event
     */
    function delete_fired_event($id)
    {
        $response = $this->db->delete('aq2emp_campaign_fired_events',array('id'=>$id));
        if($response)
        {
            return "fired event deleted successfully";
        }
        else
        {
            return "Error occuring while deleting fired event";
        }
    }
}
