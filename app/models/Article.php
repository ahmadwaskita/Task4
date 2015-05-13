<?php

class Article extends \Eloquent {
	public static function valid(){
		return array(
			'title'=>'required|min:10|unique:articles,title',
			'content'=>'required|min:10|unique:articles,content',
			'author'=>'required',
		);
	}

	
	public static function validFile($file){
		return Validator::make(
			[
				'import' 	=> $file,
				'extension'	=> Str::lower($file->getClientOriginalExtension())
			],
			[
				'import'	=> 'required',
				'extension'	=> 'required|in:xls,xlsx'
			]
		);
	}

	public function comments(){
		return $this->hasMany('Comment', 'article_id');
	}
}