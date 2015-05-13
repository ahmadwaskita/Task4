<?php

namespace AwasKita\Services\Validation;

use Illuminate\Validation\Validator as IlluminateValidator;

class ValidatorExtended extends IlluminateValidator{

	private $_custom_messages = array(
		"excel_files" => "The :attribute may only contain excel files",
	);

	public function __construct($translator, $data, $rules, $messages = array(), $customAttributes = array()){
		parent::__construct($translator, $data, $rules, $messages, $customAttributes);

		$this->_set_custom_stuff();
	}

	//setup any customization

	protected function _set_custom_stuff(){
		//setup our custom error messages
		$this->setCustomMessages($this->_custom_messages);
	}

	//Allow only excel files
	protected function validateExcelFiles($attribute, $value){
		return (bool) preg_match(^(?:[\w]\:|\\)(\\[a-z_\-\s0-9\.]+)+\.(xls|xlsx)$, $value);
	}
}