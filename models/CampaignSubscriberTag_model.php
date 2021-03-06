<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class CampaignSubscriberTag_model extends ResourceModel
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get aq2emp_campaign_subscriber_tag by id
     */
    function get_campaign_subscriber_tag($id)
    {
        return $this->db->get_where('aq2emp_campaign_subscriber_tags',array('id'=>$id))->row_array();
    }
    
    /*
     * Get all aq2emp_campaign_subscriber_tags
     */
    function get_all__campaign_subscriber_tags()
    {
        return $this->db->get('aq2emp_campaign_subscriber_tags')->result_array();
    }
    
    /*
     * function to add new aq2emp_campaign_subscriber_tag
     */
    function add_campaign_subscriber_tag($params)
    {
        $this->db->insert('aq2emp_campaign_subscriber_tags',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update aq2emp_campaign_subscriber_tag
     */
    function update_campaign_subscriber_tag($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('aq2emp_campaign_subscriber_tags',$params);
        if($response)
        {
            return "aq2emp_campaign_subscriber_tag updated successfully";
        }
        else
        {
            return "Error occuring while updating aq2emp_campaign_subscriber_tag";
        }
    }
    
    /*
     * function to delete aq2emp_campaign_subscriber_tag
     */
    function delete_campaign_subscriber_tag($id)
    {
        $response = $this->db->delete('aq2emp_campaign_subscriber_tags',array('id'=>$id));
        if($response)
        {
            return "aq2emp_campaign_subscriber_tag deleted successfully";
        }
        else
        {
            return "Error occuring while deleting aq2emp_campaign_subscriber_tag";
        }
    }
}
