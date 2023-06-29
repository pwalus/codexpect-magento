<?php
declare(strict_types=1);

namespace Codexpect\UnitTests\Test\Unit\Model;

use Codexpect\UnitTests\Api\Data\OrderEventDataInterface;
use Codexpect\UnitTests\Api\Data\OrderEventDataInterfaceFactory as OrderEventDataFactory;
use Codexpect\UnitTests\Model\Data\OrderEventData;
use Codexpect\UnitTests\Model\OrderPublisher;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Sales\Model\Order;
use PHPUnit\Framework\TestCase;

class OrderPublisherTest extends TestCase
{
    protected function setUp(): void
    {

    }
}

