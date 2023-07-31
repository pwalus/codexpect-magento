<?php
declare(strict_types=1);

namespace Codexpect\IntegrationTests\Test\Integration\Sales;

use Codexpect\IntegrationTests\Api\ActionHistoryRepositoryInterface;
use Codexpect\IntegrationTests\Api\Data\ActionHistoryInterface;
use Codexpect\IntegrationTests\Model\OrderActions;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\QuoteManagement;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * @magentoDbIsolation enabled
 * @magentoAppIsolation enabled
 */
class ActionHistoryTest extends TestCase
{

    /**
     * @magentoDataFixture Magento/Sales/_files/quote_with_customer.php
     */
    public function testPlace_OrderPlaced_ActionSaved()
    {
        // quote
        $this->quote->load('test01', 'reserved_order_id');
        // setShippingMethod
        $this->quote->getShippingAddress()
            ->setShippingMethod('flatrate_flatrate')
            ->setCollectShippingRates(true)
            ->collectShippingRates()
            ->save();
        // quote -> submit
        $order = $this->quoteManagement->submit($this->quote);

        // Action Logs fetch data

        $criteria = $this->criteriaBuilder->addFilter(ActionHistoryInterface::ORDER_ID, $order->getId())->create();
        $items = $this->actionRepository->getList($criteria)->getItems();

        $this->assertCount(1, $items);

        /** @var ActionHistoryInterface $actionHistory */
        $actionHistory = array_shift($items);

        $this->assertEquals($order->getId(), $actionHistory->getOrderId());
        $this->assertEquals(OrderActions::PLACE->value, $actionHistory->getAction());
    }

    /**
     * @magentoDataFixture Magento/Sales/_files/order.php
     */
    public function testCancel_OrderCancelled_ActionSaved()
    {
        $criteria = $this->criteriaBuilder->create();
        $items = $this->orderRepository->getList($criteria)->getItems();
        /** @var OrderInterface $order */
        $order = array_shift($items);

        $this->orderManagement->cancel($order->getEntityId());

        // Action Logs fetch data
        $criteria = $this->criteriaBuilder->addFilter(ActionHistoryInterface::ORDER_ID, $order->getId())->create();
        $items = $this->actionRepository->getList($criteria)->getItems();

        $this->assertCount(1, $items);

        /** @var ActionHistoryInterface $actionHistory */
        $actionHistory = array_shift($items);

        $this->assertEquals($order->getId(), $actionHistory->getOrderId());
        $this->assertEquals(OrderActions::CANCEL->value, $actionHistory->getAction());
    }

    public function setUp(): void
    {
        $objectManager = Bootstrap::getObjectManager();
        $this->quote = $objectManager->create(Quote::class);
        $this->quoteManagement = $objectManager->create(QuoteManagement::class);

        $this->actionRepository = $objectManager->create(ActionHistoryRepositoryInterface::class);
        $this->criteriaBuilder = $objectManager->create(SearchCriteriaBuilder::class);

        $this->orderRepository = $objectManager->create(OrderRepositoryInterface::class);
        $this->orderManagement = $objectManager->create(OrderManagementInterface::class);
    }
}
