<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ScrollPaginationController extends CI_Controller {

	function index()
	{
		$data = $this->db->select('id, post_title')->from('post')->get();
		$array['result'] = $data->result();
		$this->load->view('welcome_message', $array);
	}


	function details($id)
	{
		$data = $this->db->select('*')->from('post')->where('id', $id)->get();
		$array['result'] = $data->row();
		$this->load->view('scroll_pagination',$array);
	}


	function fetch()
	{
//		print_r($_POST); die();
		$output = '';
		$this->load->model('ScrollPaginationModel');
		$data = $this->ScrollPaginationModel->fetch_data($this->input->post('limit'), $this->input->post('start'), $this->input->post('currentId'));
//		$data = $this->ScrollPaginationModel->fetch_data(2, 0);
		if($data->num_rows() > 0)
		{
			foreach($data->result() as $row)
			{
				$output .= '
				<div class="post_data test">
					<h3 class="text-danger">'.$row->post_title.'</h3>
					<p>'.$row->post_description.'</p>
				</div>
				';
			}
		}
		echo $output;
	}

}
