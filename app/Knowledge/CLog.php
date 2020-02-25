<?php

namespace App\Knowledge;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Illuminate\Support\Facades\Cache;

/**
 * 日志类
 * Class CLog
 * @package App\Knowledge
 */
class CLog
{
    /**
     * 指定日志所有业务类型
     * CLog::with('apple_verify')->addInfo('使用示例',['1'=>'a']);
     * @param string $name
     * @param string $file_suffix
     * @return Logger
     */
    public static function with($name, $file_suffix=null)
    {
        $date = date('Ymd', time());
        $key = $name . $date . $file_suffix;
        $logger = Cache::get($key);
        if (empty($logger)) {
            $dir = Config::get('clog.dir.' . $name);
            $logger = new Logger($name);
            $path = sprintf("%s/logs/%s/%s%s.log", storage_path(), $dir, $date, empty($file_suffix) ? "" : "_" . $file_suffix);
            $logger->pushHandler(new StreamHandler($path, Logger::INFO, true, 0777));
            //$logger->pushHandler(new FirePHPHandler());
            $expiresAt = Carbon::now()->addWeek();
            Cache::put($key, $logger, $expiresAt);
        }
        return $logger;
    }

}