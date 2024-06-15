<?php

namespace lewislarsen\LogcanyonLogger\Logging;

use Monolog\Logger;

class CreateLogcanyonLogger
{
    public function __invoke(array $config): Logger
    {
        $logger = new Logger('logcanyon');

        $endpoint = config('logcanyon-logger.endpoint');
        $siteId = config('logcanyon-logger.site_id');
        $siteSecretKey = config('logcanyon-logger.site_secret_key');

        $logger->pushHandler(new LogcanyonHandler($endpoint, $siteId, $siteSecretKey));

        return $logger;
    }
}
