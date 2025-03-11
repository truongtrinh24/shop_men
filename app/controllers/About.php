<?php
class About extends Controller {
    public function index() {
        $this->data['content'] = 'blocks/clients/about';
        $this->data['sub_content']= [];
        $this->render('layouts/client_layout', $this->data);
    }
}
?>
