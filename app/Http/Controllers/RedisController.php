<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class RedisController extends Controller
{

	public function redisTest()
	{

		$redis = Redis::connection();

		try {
			var_dump($redis->ping());

			Redis::incr('visits');
			Redis::set('name', 'areg');
			$name = Redis::get('name');
			$nameexists = Redis::exists('name');

			Session::all();
			Session::put('name', 'areg');
			$sname = Session::get('name');
			Session::forget('name');
			$snameexists = Session::exists('name');

			Cache::put('name','areg',60);
			$cname = Cache::get('name');
			Cache::put('name2','areg2',now()->addDay());
			Cache::forget('name');
			//$cnameexists = Cache::has('name');
			Cache::get('name3', fn () => 'areg3');
			//Cache::Clear();

		} catch (Exception $e) {
			$e->getMessage();
		}

	}

}
