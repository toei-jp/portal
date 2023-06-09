<?php

declare(strict_types=1);

namespace App\Application\Handlers;

use Exception;
use Psr\Log\LoggerInterface;
use Slim\Handlers\Error as BaseHandler;
use Throwable;

class Error extends BaseHandler
{
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger, bool $displayErrorDetails = false)
    {
        $this->logger = $logger;

        parent::__construct($displayErrorDetails);
    }

    /**
     * @see Slim\Handlers\AbstractError
     *
     * @param Exception|Throwable $throwable
     */
    protected function writeToErrorLog($throwable): void
    {
        $this->log($throwable);
    }

    /**
     * @param Exception|Throwable $exception
     */
    protected function log($exception): void
    {
        $this->logger->error($exception->getMessage(), [
            'type' => get_class($exception),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
