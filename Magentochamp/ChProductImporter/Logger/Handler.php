<?php
namespace Magentochamp\ChProductImporter\Logger;
use Magento\Framework\Filesystem\DriverInterface;

class Handler extends \Magento\Framework\Logger\Handler\Base
{
    protected $loggerType = Logger::DEBUG;

    /**
     * File name
     * @var string
     */

    protected $fileName = '/var/log/customfile.log';
}