<?php
class ScrollPaginationModel extends CI_Model
{
	function fetch_data($limit, $start, $currentID)
	{
//		echo $limit; die();
		$this->db->select("*");
		$this->db->from("post");
		$this->db->order_by("id", "DESC");
		$this->db->where('id !=', $currentID);
		$this->db->where('id >', $currentID);
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query;
	}
}
?>
