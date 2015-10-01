<?php
namespace common\service;

class CacheService
{
	public static function get($key)
	{
		return \Yii::$app->cache->get($key);
	}

	public static function set($key,$value,$expire=0)
	{
		return \Yii::$app->cache->set($key,$value,$expire);
	}

	public static function add($key,$value,$expire=0)
	{
		return \Yii::$app->cache->add($key,$value,$expire);
	}

	public static function mget($keys)
	{
		return \Yii::$app->cache->mget($keys);
	}

	public static function mset($kvs,$expire=0)
	{
		return \Yii::$app->cache->mset($kvs,$expire);
	}

	public static function exists($key)
	{
		return \Yii::$app->cache->exists($key);
	}

	public static function delete($key)
	{
		return \Yii::$app->cache->delete($key);
	}

	public static function flush()
	{
		return \Yii::$app->cache->flush();
	}
}