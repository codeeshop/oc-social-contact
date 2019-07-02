<?php
class ControllerExtensionModuleCesSocialContact extends Controller {

  private $height = 24;
  private $width = 24;

	public function index() {
		$this->load->language('extension/module/ces_social_contact');
    
    $social_logins = array(
      'facebook',
      'linkedin',
      'twitter',
      'youtube',
      'github',      
    );

    $this->load->model('tool/image');

    $data['social_logins'] = array();

    foreach ($social_logins as $key => $value) {
      if($this->config->get('module_ces_social_contact_' . $value)) {
        
        $data['social_logins'][] = array(
          'href' => $this->config->get('module_ces_social_contact_' . $value),
          'src' => $this->model_tool_image->resize('ces_social_contact/icons-' . $value . '.png', $this->width, $this->height),
          'title' => ucfirst($value),
        );
      }
    }

		return $this->load->view('extension/module/ces_social_contact', $data);
	}

}
