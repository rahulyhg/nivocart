<?php
class ModelSaleOfferCategoryCategory extends Model {

	public function addOfferCategoryCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "offer_category_category SET name = '" . $this->db->escape($data['name']) . "', `type` = '" . $this->db->escape($data['type']) . "', discount = '" . (float)$data['discount'] . "', logged = '" . (int)$data['logged'] . "', category_one = '" . $this->db->escape($data['category_one']) . "', category_two = '" . $this->db->escape($data['category_two']) . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$offer_category_category_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_offer_category_category_id'] = $offer_category_category_id;
	}

	public function editOfferCategoryCategory($offer_category_category_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "offer_category_category SET name = '" . $this->db->escape($data['name']) . "', `type` = '" . $this->db->escape($data['type']) . "', discount = '" . (float)$data['discount'] . "', logged = '" . (int)$data['logged'] . "', category_one = '" . $this->db->escape($data['category_one']) . "', category_two = '" . $this->db->escape($data['category_two']) . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', status = '" . (int)$data['status'] . "' WHERE offer_category_category_id = '" . (int)$offer_category_category_id . "'");
	}

	public function deleteOfferCategoryCategory($offer_category_category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "offer_category_category WHERE offer_category_category_id = '" . (int)$offer_category_category_id . "'");
	}

	public function getOfferCategoryCategory($offer_category_category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "offer_category_category WHERE offer_category_category_id = '" . (int)$offer_category_category_id . "'");

		return $query->row;
	}

	public function getOfferCategoryCategories($data = array()) {
		$sql = "SELECT offer_category_category_id, name, discount, `type`, logged, date_start, date_end, status FROM " . DB_PREFIX . "offer_category_category";

		$sort_data = array(
			'name',
			'type',
			'discount',
			'logged',
			'date_start',
			'date_end',
			'status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getOfferCategoryCategoryOnes($offer_category_category_id) {
		$offer_category_one_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "offer_category_category WHERE offer_category_category_id = '" . (int)$offer_category_category_id . "'");

		foreach ($query->rows as $result) {
			$offer_category_one_data[] = $result['category_one'];
		}

		return $offer_category_one_data;
	}

	public function getOfferCategoryCategoryTwos($offer_category_category_id) {
		$offer_category_two_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "offer_category_category WHERE offer_category_category_id = '" . (int)$offer_category_category_id . "'");

		foreach ($query->rows as $result) {
			$offer_category_two_data[] = $result['category_two'];
		}

		return $offer_category_two_data;
	}

	public function getTotalOfferCategoryCategory() {
		$query = $this->db->query("SELECT COUNT(*) AS `total` FROM " . DB_PREFIX . "offer_category_category");

		return $query->row['total'];
	}
}
