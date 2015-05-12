<?php

class Article extends \Eloquent {
	public static function valid(){
		return array(
			'title'=>'required|min:10|unique:articles,title',
			'content'=>'required|min:10|unique:articles,content',
			'author'=>'required',
			'report' =>'required|mimes:xls,xlsx'
		);
	}

	public function comments(){
		return $this->hasMany('Comment', 'article_id');
	}
}