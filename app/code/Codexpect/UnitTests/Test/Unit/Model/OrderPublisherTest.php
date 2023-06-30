<?php
declare(strict_types=1);

namespace Codexpect\UnitTests\Test\Unit\Model;

use Codexpect\UnitTests\Api\Data\OrderEventDataInterface;
use Codexpect\UnitTests\Api\Data\OrderEventDataInterfaceFactory as OrderEventDataFactory;
use Codexpect\UnitTests\Model\Data\OrderEventData;
use Codexpect\UnitTests\Model\OrderPublisher;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\Order;
use PHPUnit\Framework\TestCase;

class OrderPublisherTest extends TestCase
{
    protected array $resultData = [];

    public function testPublish_OrderPlaced_OrderIsPublished()
    {
        $this->config->expects($this->once())
            ->method('getValue')
            ->willReturn(true);

        $this->order->setData(
            [
                'status' => 'processing',
                'increment_id' => '00000012',
            ]
        );

        $this->corePublisher->expects($this->once())
            ->method('publish')
            ->willReturnCallback(function ($topicName, $data) {
                $this->resultData['topic_name'] = $topicName;
                $this->resultData['data'] = $data;
            });

        $this->orderPublisher->publish($this->order);

        $this->assertEquals('test_queue', $this->resultData['topic_name']);
        /** @var OrderEventDataInterface $orderEventData */
        $orderEventData = $this->resultData['data'];
        $this->assertEquals('processing', $orderEventData->getOrderStatus());
        $this->assertEquals('00000012', $orderEventData->getIncrementId());
    }

    public function testPublish_ConfigIsDisabled_OrderIsNotPublished()
    {
        $this->config->expects($this->once())
            ->method('getValue')
            ->willReturn(false);

        $this->order->setData(
            [
                'status' => 'processing',
                'increment_id' => '00000012',
            ]
        );

        $this->corePublisher->expects($this->never())->method('publish');
        $this->orderPublisher->publish($this->order);
    }

    public function testPublish_StatusIsWrong_ExceptionIsThrown()
    {
        $this->config->expects($this->once())
            ->method('getValue')
            ->willReturn(true);

        $this->order->setData(
            [
                'status' => 'error',
                'increment_id' => '00000012',
            ]
        );

        $this->expectExceptionMessage("Order has wrong status");

        $this->orderPublisher->publish($this->order);
    }

    protected function setUp(): void
    {
        $this->corePublisher = $this->createMock(PublisherInterface::class);
        $this->config = $this->createMock(ScopeConfigInterface::class);
        $this->orderEventDataFactory = $this->createMock(OrderEventDataFactory::class);
        $this->order = $this->createPartialMock(Order::class, []);

        $this->orderEventDataFactory->method('create')
            ->willReturn(new OrderEventData());

        $this->orderPublisher = new OrderPublisher(
            $this->corePublisher,
            $this->config,
            $this->orderEventDataFactory
        );
    }
}

