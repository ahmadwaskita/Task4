<?php

class Comment extends \Eloquent {
	public static function valid(){
		return array(
			'content'=>'required'
		);
	}
}