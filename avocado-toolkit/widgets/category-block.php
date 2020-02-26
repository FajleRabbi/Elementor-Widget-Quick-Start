<?php

class Avocado_category_block extends \Elementor\Widget_Base {


    public function get_name() {
        return 'creativeWoo-slider';
    }

    public function get_title() {
        return __('CreativeWoo Slider', 'creativeWoo');
    }

    public function get_icon() {
        return 'eicon-slides';
    }

    public function get_categories() {
        return ['general'];
    }


    protected function _register_controls() {

    //Register controls in here...

    }


    protected function render() {

        $settings = $this->get_settings_for_display();

    // Render your code...
    }

}