<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class CampaignSubscription_model extends ResourceModel
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get aq2emp_campaign_subscription by id
     */
    function get_campaign_subscription($id)
    {
        return $this->db->get_where('aq2emp_campaign_subscriptions',array('id'=>intval($id)))->row_array();
    }
    
    /*
     * Get all aq2emp_campaign_subscriptions
     */
    function get_all_campaign_subscriptions()
    {
        return $this->db->get('aq2emp_campaign_subscriptions')->result_array();
    }
    
    /*
     * function to add new aq2emp_campaign_subscription
     */
    function add_campaign_subscription($params)
    {
        $this->db->insert('aq2emp_campaign_subscriptions',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update aq2emp_campaign_subscription
     */
    function update_campaign_subscription($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('aq2emp_campaign_subscriptions',$params);
        if($response)
        {
            return "aq2emp_campaign_subscription updated successfully";
        }
        else
        {
            return "Error occuring while updating aq2emp_campaign_subscription";
        }
    }
    
    /*
     * function to delete aq2emp_campaign_subscription
     */
    function delete_campaign_subscription($id)
    {
        $response = $this->db->delete('aq2emp_campaign_subscriptions',array('id'=>intval($id)));
        if($response)
        {
            return "aq2emp_campaign_subscription deleted successfully";
        }
        else
        {
            return "Error occuring while deleting aq2emp_campaign_subscription";
        }
    }
}
