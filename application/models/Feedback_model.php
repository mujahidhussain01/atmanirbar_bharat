<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Feedback_model extends CI_Model

{

    public function insert($data)

    {

        return $this->db->insert('feedback',$data);

    }

    public function get_unread_feedback_count()
    {
        $this->db->select( '*' );
        $this->db->from( 'feedback' );
        $this->db->where( 'read_status', 'UNREAD' );
        $this->db->where( 'f_type', 'FEEDBACK' );
        return $this->db->count_all_results();
    }

    public function get_unread_help_count()
    {
        $this->db->select( '*' );
        $this->db->from( 'feedback' );
        $this->db->where( 'read_status', 'UNREAD' );
        $this->db->where( 'f_type', 'HELP' );
        return $this->db->count_all_results();
    }


    public function mark_all_feedback_as_read()
    {
        $this->db->where( 'read_status', 'UNREAD' );
        $this->db->where( 'f_type', 'FEEDBACK' );

        return $this->db->update( 'feedback', [ 'read_status' => 'READ' ] );
    }

    public function mark_all_help_as_read()
    {
        $this->db->where( 'read_status', 'UNREAD' );
        $this->db->where( 'f_type', 'HELP' );

        return $this->db->update( 'feedback', [ 'read_status' => 'READ' ] );
    }
    

    public function getenquiries($type)

    {

        if($type !='ALL')

        {

            $this->db->select('*')->from('feedback f')->where('f.f_type', $type)->order_by('f_doc','desc');

            $query=$this->db->get();

        }

        else

        {

            $this->db->select('*')->from('feedback f')->order_by('f_doc','desc');;

            $query=$this->db->get();

        }

        

        return $query->result_array();

    }

}