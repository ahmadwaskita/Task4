<?php

namespace AwasKita\Services\Validation

class TestFormValidator extends Validator{
	/**
	 * @var array Validation rules for the test form, the can contain in-built Laravel rules or custom rules
	 */

	public $rules = array(
		'report' => array('required','excel_files'),
	);
}