<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class CampaignConfirmationPage_model extends ResourceModel
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get confirmation_page by id
     */
    function get_confirmation_page($id)
    {
        return $this->db->get_where('aq2emp_campaign_confirmation_page',array('id'=>intval($id)))->row_array();
    }

    /*
     * Get all confirmation_pages
     */
    function get_all_confirmation_pages()
    {
        return $this->db->get('aq2emp_campaign_confirmation_page')->result_array();
    }

    /*
     * function to add new campaign
     */
    function add_confirmation_page($params)
    {
        $this->db->insert('aq2emp_campaign_confirmation_page',$params);
        return $this->db->insert_id();
    }

    /*
     * function to update confirmation_page
     */
    function update_confirmation_page($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('aq2emp_campaign_confirmation_page',$params);
        if($response)
        {
            return "campaign_confirmation_page updated successfully";
        }
        else
        {
            return "Error occurring while updating campaign_confirmation_page";
        }
    }

    /*
     * function to delete confirmation_page
     */
    function delete_confirmation_page($id)
    {
        $response = $this->db->delete('aq2emp_campaign_confirmation_page',array('id'=>$id));
        if($response)
        {
            return "campaign_confirmation_page deleted successfully";
        }
        else
        {
            return "Error occurring while deleting campaign_confirmation_page";
        }
    }
}
