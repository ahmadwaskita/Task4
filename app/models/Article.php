<?php

class Article extends \Eloquent {
	public static function valid(){
		return array(
			'title'=>'required|min:10|unique:articles,title',
			'content'=>'required|min:10|unique:articles,content',
			'author'=>'required',
		);
	}

	
	public static function valid_file(){
		Validator::extend('require_excel', function($attribute, $value, $parameters){
			$valid_mime_type = array('application/vnd.ms-office','application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			$mime = $value->getMimeType();
			return in_aray($mime, $valid_mime_type);
		});
		return array(
			//'import_file' => 'mimes:xls'
			'import_file' => 'require_excel'
		);
	}

	public function comments(){
		return $this->hasMany('Comment', 'article_id');
	}
}