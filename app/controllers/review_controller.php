<?php

class ReviewController extends BaseController{
	public static function newReview(){
		View::make('review/new.html'); 
	}
}