<?php
class ControllerExtensionModuleCesSocialContact extends Controller {
	
	private $error = array();

	public function index() {
		
		$this->load->language('extension/module/ces_social_contact');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_ces_social_contact', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/ces_social_contact', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/ces_social_contact', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		$configs = $this->getConfig();

		foreach ($configs as $config) {
			if (isset($this->request->post[$config])) {
				$data[$config] = $this->request->post[$config];
			} else {
				$data[$config] = $this->config->get('module_' . $config);
			}
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/ces_social_contact', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/ces_social_contact')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if(isset($this->request->post) && count($this->request->post)) {			
			foreach ($this->request->post as $config => $value) {
				if (isset($this->request->post[$config])) {
					$this->request->post[$config] = trim($this->request->post[$config]);
				}
			}
		}

		return !$this->error;
	}

	public function getConfig() {
			return array(
				'ces_social_contact_status',
				'ces_social_contact_facebook',
				'ces_social_contact_twitter',
				'ces_social_contact_linkedin',				
				'ces_social_contact_youtube',
				'ces_social_contact_github',
				'ces_social_contact_add_remove_category_product',
			);
	}
}
