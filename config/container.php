<?php
/**
 * container.php
 * 
 * AbstractControllerのphpdoc更新を推奨。
 * 
 * @see Toei\PortalAdmin\Controller\AbstractController\__call()
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

/** @var \Slim\App $app */
$container = $app->getContainer();

/** 
 * view
 * 
 * @link https://www.slimframework.com/docs/v3/features/templates.html
 * 
 * @return \Slim\Views\Twig
 */
$container['view'] = function ($container) {
    $settings = $container->get('settings')['view'];
    
    $view = new \Slim\Views\Twig($settings['template_path'], $settings['settings']);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $basePath));
    
    // add Extension
    $view->addExtension(new \Twig_Extension_Debug());
    
    return $view;
};

/**
 * logger
 * 
 * @link https://github.com/Seldaek/monolog
 * 
 * @return \Monolog\Logger
 */
$container['logger'] = function ($container) {
    $settings = $container->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    
    $logger->pushProcessor(new Monolog\Processor\PsrLogMessageProcessor());
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushProcessor(new Monolog\Processor\IntrospectionProcessor());
    $logger->pushProcessor(new Monolog\Processor\WebProcessor());
    $logger->pushProcessor(new Monolog\Processor\MemoryUsageProcessor());
    $logger->pushProcessor(new Monolog\Processor\MemoryPeakUsageProcessor());
    
    if (isset($settings['chrome_php'])) {
        $chromePhpSettings = $settings['chrome_php'];
        $logger->pushHandler(new Monolog\Handler\ChromePHPHandler(
            $chromePhpSettings['level']
        ));
    }
    
    $azureBlobStorageSettings = $settings['azure_blob_storage'];
    $azureBlobStorageHandler = new Toei\Portal\Logger\Handler\AzureBlobStorageHandler(
        $container->get('bc'),
        $azureBlobStorageSettings['container'],
        $azureBlobStorageSettings['blob'],
        $azureBlobStorageSettings['level']
    );
    
    $fingersCrossedSettings = $settings['fingers_crossed'];
    $logger->pushHandler(new Monolog\Handler\FingersCrossedHandler(
        $azureBlobStorageHandler,
        $fingersCrossedSettings['activation_strategy']
    ));
    
    return $logger;
};

/**
 * Doctrine entity manager
 * 
 * @return \Doctrine\ORM\EntityManager
 */
$container['em'] = function ($container) {
    $settings = $container->get('settings')['doctrine'];
    
    /**
     * 第５引数について、他のアノテーションとの競合を避けるためSimpleAnnotationReaderは使用しない。
     * @Entity => @ORM\Entity などとしておく。
     */
    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        $settings['metadata_dirs'],
        $settings['dev_mode'],
        null,
        null,
        false
    );
    
    $config->setProxyDir(APP_ROOT . '/src/ORM/Proxy');
    $config->setProxyNamespace('Toei\Portal\ORM\Proxy');
    $config->setAutoGenerateProxyClasses($settings['dev_mode']);
    
    $logger = new \Toei\Portal\Logger\DbalLogger($container->get('logger'));
    $config->setSQLLogger($logger);
    
    return \Doctrine\ORM\EntityManager::create($settings['connection'], $config);
};

/**
 * Azure Blob Storage Client
 * 
 * @link https://github.com/Azure/azure-storage-php/tree/master/azure-storage-blob
 * @return \MicrosoftAzure\Storage\Blob\BlobRestProxy
 */
$container['bc'] = function ($container) {
    $settings = $container->get('settings')['storage'];
    $protocol = $settings['secure'] ? 'https' : 'http';
    $connectionString = sprintf(
        'DefaultEndpointsProtocol=%s;AccountName=%s;AccountKey=%s',
        $protocol,
        $settings['account']['name'],
        $settings['account']['key']);
    
    return \MicrosoftAzure\Storage\Blob\BlobRestProxy::createBlobService($connectionString);
};

$container['errorHandler'] = function ($container) {
    return new \Toei\Portal\Application\Handlers\Error($container);
};

$container['phpErrorHandler'] = function ($container) {
    return new \Toei\Portal\Application\Handlers\PhpError($container);
};

$container['notFoundHandler'] = function ($container) {
    return new \Toei\Portal\Application\Handlers\NotFound($container);
};

$container['notAllowedHandler'] = function ($container) {
    return new \Toei\Portal\Application\Handlers\NotAllowed($container);
};
