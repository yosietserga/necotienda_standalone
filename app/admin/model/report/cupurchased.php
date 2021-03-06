<?php
class ModelReportCUPurchased extends Model {
	public function getCustomerPurchasedReport($start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}
		
		if ($limit < 1) {
			$limit = 20;
		}
		
		$query = $this->db->query("SELECT CONCAT(firstname, ' ', lastname) AS cname, email, SUM(op.quantity) AS quantity, SUM(op.total + op.tax) AS total FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (op.order_id = o.order_id) WHERE o.order_status_id > '0' GROUP BY email ORDER BY total DESC LIMIT " . (int)$start . "," . (int)$limit);
	
		return $query->rows;
	}
	
	public function getTotalOrderedProducts() {
      	$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_product` GROUP BY model");
		
		return $query->num_rows;
	}
}
