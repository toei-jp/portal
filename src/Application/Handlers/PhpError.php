<?php

declare(strict_types=1);

namespace App\Application\Handlers;

use Exception;
use Psr\Log\LoggerInterface;
use Slim\Handlers\PhpError as BaseHandler;
use Throwable;

class PhpError extends BaseHandler
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

    protected function log(Throwable $error): void
    {
        $this->logger->error($error->getMessage(), [
            'type' => get_class($error),
            'code' => $error->getCode(),
            'file' => $error->getFile(),
            'line' => $error->getLine(),
            'trace' => $error->getTraceAsString(),
        ]);
    }
}
