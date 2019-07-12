<?php

use App\Helpers\General\HtmlHelper;
use App\Helpers\General\Timezone;
use App\Repositories\Backend\Post\PostRepository;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Models\Country\Country;

/*
 * Global helpers file with misc functions.
 */
if (!function_exists('app_name')) {
	/**
	 * Helper to grab the application name.
	 *
	 * @return mixed
	 */
	function app_name() {
		return (app('app_name')) ? app('app_name') : config('app.name');
	}
}

if (!function_exists('gravatar')) {
	/**
	 * Access the gravatar helper.
	 */
	function gravatar() {
		return app('gravatar');
	}
}

if (!function_exists('timezone')) {
	/**
	 * Access the timezone helper.
	 */
	function timezone() {
		return resolve(Timezone::class);
	}
}

if (!function_exists('include_route_files')) {

	/**
	 * Loops through a folder and requires all PHP files
	 * Searches sub-directories as well.
	 *
	 * @param $folder
	 */
	function include_route_files($folder) {
		try {
			$rdi = new recursiveDirectoryIterator($folder);
			$it = new recursiveIteratorIterator($rdi);

			while ($it->valid()) {
				if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
					require $it->key();
				}

				$it->next();
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}

if (!function_exists('home_route')) {

	/**
	 * Return the route to the "home" page depending on authentication/authorization status.
	 *
	 * @return string
	 */
	function home_route() {
		
		if (auth()->check()) {
			if (auth()->user()->can('view backend')) {
				return 'admin.dashboard';
			} else {
				return 'frontend.index';
			}
		}

		return 'frontend.index';
	}
}

if (!function_exists('style')) {

	/**
	 * @param       $url
	 * @param array $attributes
	 * @param null  $secure
	 *
	 * @return mixed
	 */
	function style($url, $attributes = [], $secure = null) {
		return resolve(HtmlHelper::class)->style($url, $attributes, $secure);
	}
}

if (!function_exists('script')) {

	/**
	 * @param       $url
	 * @param array $attributes
	 * @param null  $secure
	 *
	 * @return mixed
	 */
	function script($url, $attributes = [], $secure = null) {
		return resolve(HtmlHelper::class)->script($url, $attributes, $secure);
	}
}

if (!function_exists('form_cancel')) {

	/**
	 * @param        $cancel_to
	 * @param        $title
	 * @param string $classes
	 *
	 * @return mixed
	 */
	function form_cancel($cancel_to, $title, $classes = 'btn btn-danger btn-sm') {
		return resolve(HtmlHelper::class)->formCancel($cancel_to, $title, $classes);
	}
}

if (!function_exists('form_submit')) {

	/**
	 * @param        $title
	 * @param string $classes
	 *
	 * @return mixed
	 */
	function form_submit($title, $classes = 'btn btn-success btn-sm pull-right') {
		return resolve(HtmlHelper::class)->formSubmit($title, $classes);
	}
}

if (!function_exists('camelcase_to_word')) {

	/**
	 * @param $str
	 *
	 * @return string
	 */
	function camelcase_to_word($str) {
		return implode(' ', preg_split('/
          (?<=[a-z])
          (?=[A-Z])
        | (?<=[A-Z])
          (?=[A-Z][a-z])
        /x', $str));
	}
}

if (!function_exists('truncate')) {
	function truncate($text, $limit, $ellipsis = '...') {
		$words = preg_split("/[\n\r\t ]+/", $text, $limit + 1, PREG_SPLIT_NO_EMPTY);
		if (count($words) > $limit) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $ellipsis;
		}
		return $text;
	}
}

if (!function_exists('getUserName')) {
	function getUserName($id) {
		$user = UserRepository::getUserByID($id);
		return $user->first_name . ' ' . $user->last_name;
	}
}

if (!function_exists('get_client_ip')) {
	// Function to get the client IP address
	function get_client_ip() {
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP')) {
			$ipaddress = getenv('HTTP_CLIENT_IP');
		} else if (getenv('HTTP_X_FORWARDED_FOR')) {
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		} else if (getenv('HTTP_X_FORWARDED')) {
			$ipaddress = getenv('HTTP_X_FORWARDED');
		} else if (getenv('HTTP_FORWARDED_FOR')) {
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		} else if (getenv('HTTP_FORWARDED')) {
			$ipaddress = getenv('HTTP_FORWARDED');
		} else if (getenv('REMOTE_ADDR')) {
			$ipaddress = getenv('REMOTE_ADDR');
		} else {
			$ipaddress = 'UNKNOWN';
		}

		return $ipaddress;
	}
}

if (!function_exists('getPostUserLike')) {
	function getPostUserLike($uid, $pid) {
		$likes = PostRepository::getPostLike($uid, $pid);
		if ($likes != null) {
			return true;
		} else {
			return false;
		}
	}
}

if (!function_exists('getCommentUserLike')) {
	function getCommentUserLike($uid, $cid) {
		$likes = PostRepository::getCommentLike($uid, $cid);
		if ($likes != null) {
			return true;
		} else {
			return false;
		}
	}
}

if (!function_exists('getCountryName')) {
	function getCountryName($id) {
		$country_name = Country::where('id',$id)->first();
		return $country_name->nicename;
	}
}
