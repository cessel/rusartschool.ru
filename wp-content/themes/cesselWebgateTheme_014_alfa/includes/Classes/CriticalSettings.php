<?php
/**
 * Created by Cessel's WEBGate Studio.
 * User: Cessel
 * Date: 24.06.2021
 * Time: 10:21
 */

class CriticalSettings {
	public $options;
	public $backgrounds;

	public function __construct() {
		try{
			if(function_exists('get_fields')){
				$this->setOptions();
			}
		}
		catch(Error $exception){
			echo '<pre>'.print_r($exception->getMessage(),true).'</pre>';
		}
		$this->setConstants();
	}
	protected function setConstants(){
		if(!defined('WCAG_ENABLE')){
			define('WCAG_ENABLE',$this->getOptions('wcag_enable','bool'));
		}
		if(!defined('CWG_TEXT_DOMAIN')){
			define('CWG_TEXT_DOMAIN','cessel_webgate_theme');
		}
		if(!defined('SUKKOT_SPINNER_HTML')){
			define('SUKKOT_SPINNER_HTML','<i class="icon-spin icon-2x animate-spin"></i>');
		}
		if(!defined('ICL_LANGUAGE_CODE')){
			define('ICL_LANGUAGE_CODE','he');
		}
		if(!defined('CSS_DIR')){
			define('CSS_DIR',get_template_directory_uri().'/css');
		}

		if(!defined('FONTS_DIR')){
			define('FONTS_DIR',CSS_DIR.'/fonts');
		}
		if(!defined('MAIN_BLOG_ID')){
			define('MAIN_BLOG_ID',4);
		}
	}


	public function setOptions() {
		if(!empty($options)){
			$this->options = $options;
		} else{
			if(get_fields('options')){
				$this->options = get_fields('options');
			} else{
				$this->options = [];
			}
		}
	}
	public function getOptions2($selector, $return_type = 'array') {
		if(isset($this->options[ $selector ])){
			if(empty($this->options[ $selector ])){
				if(get_current_blog_id() == MAIN_BLOG_ID){
					return self::emptyOptionReturn($return_type);
				} else {
					$this->setDefaultOption($selector);
				}
			}
		}



	}

	public function setDefaultOption($selector) {
		if(get_current_blog_id() != MAIN_BLOG_ID){
			switch_to_blog( MAIN_BLOG_ID );
			$default_option = get_field($selector,'options');
			restore_current_blog();
			if(isset($default_option)&&!empty($default_option)){
				$this->options[ $selector ] = $default_option;
				return $this->options[ $selector ];
			} else{
				return false;
			}


		}
	}
	public function getOptions($selector, $return_type = 'array') {
		if ( isset( $this->options[ $selector ] ) && ! empty( $this->options[ $selector ] ) ) {
			if ( is_array( $this->options[ $selector ] ) ) {
				foreach ( $this->options[ $selector ] as $option ) {
					if ( ! empty( $option ) ) {
						return $this->options[ $selector ];
					} else {
						break;
					}
				}

			} else {
				return $this->options[ $selector ];
			}
		} else {
			return self::emptyOptionReturn($return_type);
		}
	}

	public static function emptyOptionReturn( $return_type ) {
		switch ( $return_type ) {
			case 'string':
				return '';
			case 'bool':
				return false;
			case 'int':
				return 0;
			default:
			case 'array':
				return [];
		}
	}
}