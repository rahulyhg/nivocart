<?php
class ControllerModificationBlogs extends Controller {
	private $error = array();
	private $_name = 'blogs';

	public function index() {
		$url = $this->request->get['route'];

		if ($this->validateDatabase()) {
			$this->language->load('blog/install');

			$this->document->setTitle($this->language->get('error_database'));

			$this->data['install_blog'] = $this->url->link('modification/blogs', 'token=' . $this->session->data['token'] . '&url=' . $url, 'SSL');

			$this->data['text_install_message'] = $this->language->get('text_install_message');
			$this->data['text_upgrade'] = $this->language->get('text_upgrade');

			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			);

			$this->template = 'blog/notification.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);

			$this->response->setOutput($this->render());
		} else {
			$this->setting();
		}
	}

	public function validateDatabase() {
		$database_not_found = $this->getChild('blog/install');

		if ($database_not_found) {
			return true;
		}

		return false;
	}

	public function setting() {
		$this->language->load('modification/blogs');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('blogs', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['header_set_option'] = $this->language->get('header_set_option');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');

		$this->data['entry_blog_heading'] = $this->language->get('entry_blog_heading');
		$this->data['entry_related_heading'] = $this->language->get('entry_related_heading');
		$this->data['entry_comment_heading'] = $this->language->get('entry_comment_heading');

		$this->data['entry_comment_approval'] = $this->language->get('entry_comment_approval');
		$this->data['entry_show_author'] = $this->language->get('entry_show_author');
		$this->data['entry_author_information'] = $this->language->get('entry_author_information');
		$this->data['entry_social_network'] = $this->language->get('entry_social_network');
		$this->data['entry_related_article'] = $this->language->get('entry_related_article');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_modification'),
			'href'      => $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('modification/blogs', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('modification/blogs', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL');

		// Header
		if (isset($this->request->post['blog_heading'])) {
			$this->data['blog_heading'] = $this->request->post['blog_heading'];
		} else {
			$this->data['blog_heading'] = $this->config->get('blog_heading');
		}

		if (isset($this->request->post['product_related_heading'])) {
			$this->data['product_related_heading'] = $this->request->post['product_related_heading'];
		} else {
			$this->data['product_related_heading'] = $this->config->get('product_related_heading');
		}

		if (isset($this->request->post['comment_related_heading'])) {
			$this->data['comment_related_heading'] = $this->request->post['comment_related_heading'];
		} else {
			$this->data['comment_related_heading'] = $this->config->get('comment_related_heading');
		}

		// Options
		if (isset($this->request->post['blog_comment_auto_approval'])) {
			$this->data['blog_comment_auto_approval'] = $this->request->post['blog_comment_auto_approval'];
		} else {
			$this->data['blog_comment_auto_approval'] = $this->config->get('blog_comment_auto_approval');
		}

		if (isset($this->request->post['blog_show_authors'])) {
			$this->data['blog_show_authors'] = $this->request->post['blog_show_authors'];
		} else {
			$this->data['blog_show_authors'] = $this->config->get('blog_show_authors');
		}

		if (isset($this->request->post['blog_author_information'])) {
			$this->data['blog_author_information'] = $this->request->post['blog_author_information'];
		} else {
			$this->data['blog_author_information'] = $this->config->get('blog_author_information');
		}

		if (isset($this->request->post['blog_share_social_site'])) {
			$this->data['blog_share_social_site'] = $this->request->post['blog_share_social_site'];
		} else {
			$this->data['blog_share_social_site'] = $this->config->get('blog_share_social_site');
		}

		if (isset($this->request->post['blog_related_articles'])) {
			$this->data['blog_related_articles'] = $this->request->post['blog_related_articles'];
		} else {
			$this->data['blog_related_articles'] = $this->config->get('blog_related_articles');
		}

		$this->template = 'modification/blogs.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'modification/blogs')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}

	public function install() {
	// Create blog article table
$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_article`");
$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_article (
  `blog_article_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_author_id` int(11) NOT NULL,
  `allow_comment` tinyint(1) NOT NULL,
  `image` text NOT NULL,
  `featured_image` text NOT NULL,
  `article_related_method` varchar(64) NOT NULL,
  `article_related_option` text NOT NULL,
  `sort_order` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`blog_article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

	// Create blog article description table
$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_article_description`");
$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_article_description (
  `blog_article_description_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_article_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `article_title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL,
  PRIMARY KEY (`blog_article_description_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

	// Create blog article table
$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_article_description_additional`");
$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_article_description_additional (
  `blog_article_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `additional_description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

	// Create blog article product related table
$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_article_product_related`");
$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_article_product_related (
  `blog_article_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

	// Create blog article to category table
$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_article_to_category`");
$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_article_to_category (
  `blog_article_id` int(11) NOT NULL,
  `blog_category_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

	// Create blog article to layout table
$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_article_to_layout`");
$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_article_to_layout (
  `blog_article_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

	// Create blog article to store table
$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_article_to_store`");
$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_article_to_store (
  `blog_article_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

	// Create blog author table
$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_author`");
$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_author (
  `blog_author_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`blog_author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

	// Create blog author description table
$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_author_description`");
$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_author_description (
  `blog_author_description_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_author_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`blog_author_description_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

	// Create blog category table
$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_category`");
$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_category (
  `blog_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` text NOT NULL,
  `parent_id` int(11) NOT NULL,
  `top` tinyint(1) NOT NULL,
  `blog_category_column` int(11) NOT NULL,
  `column` int(8) NOT NULL,
  `sort_order` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`blog_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

	// Create blog category description table
$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_category_category`");
$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_category_description (
  `blog_category_description_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL,
  PRIMARY KEY (`blog_category_description_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

	// Create blog category to layout table
$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_category_to_layout`");
$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_category_to_layout (
  `blog_category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

	// Create blog category to store table
$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_category_to_store`");
$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_category_to_store (
  `blog_category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

	// Create blog comment table
$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_comment`");
$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_comment (
  `blog_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_article_id` int(11) NOT NULL,
  `blog_article_reply_id` int(11) NOT NULL,
  `author` varchar(64) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`blog_comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

		// Create blog related article table
$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_related_article`");
$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_related_article (
  `blog_related_article_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_article_id` int(11) NOT NULL,
  `blog_article_related_id` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`blog_related_article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

	// Create blog view table
$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_view`");
$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_view (
  `blog_view_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_article_id` int(11) NOT NULL,
  `view` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`blog_view_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

		// Check layout
		$sql = "SELECT layout_id FROM `" . DB_PREFIX . "layout` WHERE `name` LIKE 'Blog' LIMIT 0,1";

		$query = $this->db->query($sql);

		if ($query->num_rows == 0) {
			$sql = "INSERT INTO `" . DB_PREFIX . "layout` SET `name` = 'Blog'";

			$this->db->query($sql);
		}

		$stores = array();

		$sql = "SELECT store_id FROM `" . DB_PREFIX . "store`";

		$query = $this->db->query($sql);

		foreach ($query->rows as $store) {
			$stores[] = $store['store_id'];
		}

		// Check layout route
		$newRoutes = array('blog/article', 'blog/author', 'blog/category', 'blog/search');

		foreach ($newRoutes as $newRoute) {
			foreach ($stores as $store_id) {
				$sql = "SELECT layout_id FROM `" . DB_PREFIX . "layout_route` WHERE store_id = '" . (int)$store_id . "' AND `route` LIKE '" . $newRoute . "' LIMIT 0,1";

				$query = $this->db->query($sql);

				if ($query->num_rows == 0) {
					$sql = "INSERT INTO `" . DB_PREFIX . "layout_route` SET `layout_id`= (SELECT layout_id FROM `" . DB_PREFIX . "layout` WHERE `name` LIKE 'Blog' LIMIT 0,1), store_id = '" . (int)$store_id . "', `route` = '" . $newRoute . "'";

					$this->db->query($sql);
				}
			}
		}
	}

	public function uninstall() {
		$this->cache->delete('blog_author');
		$this->cache->delete('blog_category');

		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_article`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_article_description`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_article_description_additional`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_article_product_related`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_article_to_category`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_article_to_layout`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_article_to_store`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_author`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_author_description`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_category`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_category_description`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_category_to_layout`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_category_to_store`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_comment`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_related_article`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "blog_view`");

		$this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE `query` LIKE 'blog_article_id=%'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE `query` LIKE 'blog_author_id=%'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE `query` LIKE 'blog_category_id=%'");
    }
}
