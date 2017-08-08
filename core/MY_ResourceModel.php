<?php

/**
 * Created by PhpStorm.
 * User: niran
 * Date: 5/23/2017
 * Time: 4:28 PM
 */
class ResourceModel extends CI_Model
{
    protected $results;

    public function __construct()
    {
        parent::__construct();
        $this->results = [];
    }

    protected function toJSON() {
        return json_encode( $this->results );
    }

}