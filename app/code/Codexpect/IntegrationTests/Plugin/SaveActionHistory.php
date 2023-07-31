<?php
declare(strict_types=1);

namespace Codexpect\IntegrationTests\Plugin;

use Codexpect\IntegrationTests\Api\ActionHistoryRepositoryInterface;
use Codexpect\IntegrationTests\Api\Data\ActionHistoryInterfaceFactory;
use Codexpect\IntegrationTests\Model\OrderActions;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderManagementInterface;

class SaveActionHistory
{
    private ActionHistoryInterfaceFactory $actionHistoryFactory;
    private ActionHistoryRepositoryInterface $actionHistoryRepository;

    public function __construct(ActionHistoryInterfaceFactory $actionHistoryFactory, ActionHistoryRepositoryInterface $actionHistoryRepository)
    {
        $this->actionHistoryFactory = $actionHistoryFactory;
        $this->actionHistoryRepository = $actionHistoryRepository;
    }

    /**
     * @param OrderManagementInterface $subject
     * @param OrderInterface $order
     * @return OrderInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.EmptyCatchBlock)
     */
    public function afterPlace(OrderManagementInterface $subject, OrderInterface $order): OrderInterface
    {
        try {
            $actionHistory = $this->actionHistoryFactory->create();
            $actionHistory->setOrderId((int)$order->getEntityId());
            $actionHistory->setAction(OrderActions::PLACE->value);
            $this->actionHistoryRepository->save($actionHistory);
        } catch (LocalizedException $e) {
            // save logs
        }
        return $order;
    }

    /**
     * @param OrderManagementInterface $subject
     * @param bool $result
     * @param int $orderId
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.EmptyCatchBlock)
     */
    public function afterCancel(OrderManagementInterface $subject, bool $result, int $orderId): bool
    {
        try {
            $actionHistory = $this->actionHistoryFactory->create();
            $actionHistory->setOrderId((int)$orderId);
            $actionHistory->setAction(OrderActions::CANCEL->value);
            $this->actionHistoryRepository->save($actionHistory);
        } catch (LocalizedException $e) {
            // save logs
        }
        return $result;
    }
}
