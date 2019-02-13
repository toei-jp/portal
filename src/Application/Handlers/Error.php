<?php
/**
 * Error.php
 *
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\Application\Handlers;

use Slim\Container;
use Slim\Handlers\Error as BaseHandler;

/**
 * Error handler
 */
class Error extends BaseHandler
{
    /** @var Container */
    protected $container;
    
    /** @var \Monolog\Logger */
    protected $logger;
    
    /**
     * construct
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->logger = $container->get('logger');
        
        parent::__construct($container->get('settings')['displayErrorDetails']);
    }
    
    /**
     *  Write to the error log
     *
     * @see Slim\Handlers\AbstractError
     *
     * @param \Exception|\Throwable $throwable
     * @return void
     */
    protected function writeToErrorLog($throwable)
    {
        $this->log($throwable);
    }
    
    /**
     * log
     *
     * @param \Exception $exception
     * @return void
     */
    protected function log(\Exception $exception)
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
