<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Campaigns_queue_report_model extends ResourceModel
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get aq2emp_campaigns_queue_report by id
     */
    function get_aq2emp_campaigns_queue_report($id)
    {
        return $this->db->get_where('aq2emp_campaigns_queue_report',array('id'=>$id))->row_array();
    }
    
    /*
     * Get all aq2emp_campaigns_queue_report
     */
    function get_all_aq2emp_campaigns_queue_report()
    {
        return $this->db->get('aq2emp_campaigns_queue_report')->result_array();
    }
    
    /*
     * function to add new aq2emp_campaigns_queue_report
     */
    function add_aq2emp_campaigns_queue_report($params)
    {
        $this->db->insert('aq2emp_campaigns_queue_report',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update aq2emp_campaigns_queue_report
     */
    function update_aq2emp_campaigns_queue_report($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('aq2emp_campaigns_queue_report',$params);
        if($response)
        {
            return "aq2emp_campaigns_queue_report updated successfully";
        }
        else
        {
            return "Error occuring while updating aq2emp_campaigns_queue_report";
        }
    }
    
    /*
     * function to delete aq2emp_campaigns_queue_report
     */
    function delete_aq2emp_campaigns_queue_report($id)
    {
        $response = $this->db->delete('aq2emp_campaigns_queue_report',array('id'=>$id));
        if($response)
        {
            return "aq2emp_campaigns_queue_report deleted successfully";
        }
        else
        {
            return "Error occuring while deleting aq2emp_campaigns_queue_report";
        }
    }
}