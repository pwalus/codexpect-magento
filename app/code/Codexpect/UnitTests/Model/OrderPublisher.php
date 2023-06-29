<?php
declare(strict_types=1);

namespace Codexpect\UnitTests\Model;

use Codexpect\UnitTests\Api\Data\OrderEventDataInterface;
use Codexpect\UnitTests\Api\Data\OrderEventDataInterfaceFactory as OrderEventDataFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Sales\Api\Data\OrderInterface;

class OrderPublisher
{
    /**
     * @param PublisherInterface $publisher
     * @param ScopeConfigInterface $config
     * @param OrderEventDataFactory $orderEventDataFactory
     */
    public function __construct(
        private readonly PublisherInterface    $publisher,
        private readonly ScopeConfigInterface  $config,
        private readonly OrderEventDataFactory $orderEventDataFactory
    ) {
    }

    /**
     * @param OrderInterface $order
     * @return void
     * @throws LocalizedException
     */
    public function publish(OrderInterface $order): void
    {

    }
}
