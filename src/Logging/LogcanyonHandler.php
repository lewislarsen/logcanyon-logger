<?php

namespace lewislarsen\LogcanyonLogger\Logging;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\LogRecord;

class LogcanyonHandler extends AbstractProcessingHandler
{
    protected Client $client;
    protected string $endpoint;
    protected string $siteId;
    protected string $siteSecretKey;

    public function __construct($endpoint, $siteId, $siteSecretKey, $level = Logger::DEBUG, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
        $this->client = new Client();
        $this->endpoint = $endpoint;
        $this->siteId = $siteId;
        $this->siteSecretKey = $siteSecretKey;
    }

    protected function write(array|LogRecord $record): void
    {
        try {
            $this->client->post($this->endpoint, [
                'json' => [
                    'site_id' => $this->siteId,
                    'site_secret_key' => $this->siteSecretKey,
                    'level' => $record['level_name'],
                    'message' => $record['message'],
                    'context' => $record['context'],
                ],
            ]);
        } catch (Exception $e) {
            Log::channel('stack')->error('Failed to send log to Logcanyon: ' . $e->getMessage());
        }
    }
}
