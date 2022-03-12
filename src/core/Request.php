<?php
 class Request
 {
    public function __construct() {}


    // POSTか？
    public static function isPost()
	{
		if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] === 'POST')) {
			return true;
		}

		return false;
	}


	// Ajaxか？
	public static function isAjax()
	{
		$ret = false;

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			$ret = (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
				? true
				: false;
		}

		return $ret;
	}


    // POSTデータ取得
    public static function post($name = null, $default = null)
	{
		$ret = $default;

		$post = array_change_key_case($_POST);

		if (is_null($name) || ($name === '')) {
			$ret = $post;
		} else {
			$name = strtolower($name);
			if (isset($post[$name])) {
				$ret = $post[$name];
			}
		}

		return $ret;
	}

	
	// GETデータ取得
	public static function get($name = null, $default = null)
	{
		$ret = $default;

		$get = array_change_key_case($_GET);

		if (is_null($name) || ($name === '')) {
			$ret = $get;
		} else {
			$name = strtolower($name);
			if (isset($get[$name])) {
				$ret = $get[$name];
			}
		}

		return $ret;
	}
 }