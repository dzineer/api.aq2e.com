<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class CampaignForm_model extends ResourceModel
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get aq2emp_campaign_form by id
     */
    function get_campaign_form($id)
    {
        return $this->db->get_where('aq2emp_campaign_forms',array('id'=>$id))->row_array();
    }
    
    /*
     * Get all aq2emp_campaign_forms
     */
    function get_all_campaign_forms()
    {
        return $this->db->get('aq2emp_campaign_forms')->result_array();
    }
    
    /*
     *
     
		SELECT cfp.[id]
		      ,cfp.[campaign_id]
		      ,cfp.[form_id]
		      ,cfp.[main_bg]
		      ,cfp.[main_header]
		      ,cfp.[main_sub_header]
		      ,cfp.[main_sub_sub_header]
		      ,cfp.[top_image]
		      ,cf.[form_title]
		      ,cf.[form_sub_text]
		      ,cf.[form_image]
		  FROM [aq2e_marketing_platforrm].[dbo].[aq2emp_campaign_forms_page] cfp
		   INNER JOIN [aq2e_marketing_platforrm].[dbo].[aq2emp_campaign_forms] cf ON cf.id = cfp.form_id
		   WHERE cfp.[id] = 12362
		
		  SELECT cff.[name]
		      ,cff.[order]
		      ,cff.[type]
		      ,cff.[required]
		  FROM [aq2e_marketing_platforrm].[dbo].[aq2emp_campaign_form_fields] cff
		  WHERE cff.form_id = 1
     *
     */
    
    /*
     * function to add new aq2emp_campaign_form
     */
    function add_campaign_form($params)
    {
        $this->db->insert('aq2emp_campaign_forms',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update aq2emp_campaign_form
     */
    function update_campaign_form($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('aq2emp_campaign_forms',$params);
        if($response)
        {
            return "aq2emp_campaign_form updated successfully";
        }
        else
        {
            return "Error occuring while updating aq2emp_campaign_form";
        }
    }
    
    /*
     * function to delete aq2emp_campaign_form
     */
    function delete_campaign_form($id)
    {
        $response = $this->db->delete('aq2emp_campaign_forms',array('id'=>$id));
        if($response)
        {
            return "aq2emp_campaign_form deleted successfully";
        }
        else
        {
            return "Error occuring while deleting aq2emp_campaign_form";
        }
    }
}
