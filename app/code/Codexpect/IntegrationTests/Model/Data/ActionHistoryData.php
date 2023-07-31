<?php

namespace Codexpect\IntegrationTests\Model\Data;

use Codexpect\IntegrationTests\Api\Data\ActionHistoryInterface;
use Magento\Framework\DataObject;

class ActionHistoryData extends DataObject implements ActionHistoryInterface
{
    /**
     * @return int
     */
    public function getId(): int
    {
        return (int)$this->getData(self::ID);
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return (int)$this->getData(self::ORDER_ID);
    }

    /**
     * @param int $orderId
     *
     * @return void
     */
    public function setOrderId(int $orderId): void
    {
        $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return (string)$this->getData(self::ACTION);
    }

    /**
     * @param string $action
     *
     * @return void
     */
    public function setAction(string $action): void
    {
        $this->setData(self::ACTION, $action);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return (string)$this->getData(self::CREATED_AT);
    }
}
