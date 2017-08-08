<?php

/**
 * Created by PhpStorm.
 * User: niran
 * Date: 5/28/2017
 * Time: 12:52 PM
 */
class Ins112aq2esite_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get ins112_aq2e_site by id
     */
    function get_ins112_aq2e_site($id)
    {
        return $this->db->get_where('ins112_aq2e_site',array('site_num'=>$id))->row_array();
    }

    /*
     * Get all ins112_aq2e_site
     */
    function get_all_ins112_aq2e_site()
    {
        return $this->db->get('ins112_aq2e_site')->result_array();
    }

    /*
     * function to add new ins112_aq2e_site
     */
    function add_ins112_aq2e_site($params)
    {
        $this->db->insert('ins112_aq2e_site',$params);
        return $this->db->insert_id();
    }

    /*
     * function to update ins112_aq2e_site
     */
    function update_ins112_aq2e_site($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('ins112_aq2e_site',$params);
        if($response)
        {
            return "ins112_aq2e_site updated successfully";
        }
        else
        {
            return "Error occuring while updating ins112_aq2e_site";
        }
    }

    /*
     * function to delete ins112_aq2e_site
     */
    function delete_ins112_aq2e_site($id)
    {
        $response = $this->db->delete('ins112_aq2e_site',array('id'=>$id));
        if($response)
        {
            return "ins112_aq2e_site deleted successfully";
        }
        else
        {
            return "Error occuring while deleting ins112_aq2e_site";
        }
    }
}
