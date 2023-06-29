<?php

namespace Codexpect\UnitTests\Model\Data;

use Codexpect\UnitTests\Api\Data\OrderEventDataInterface;
use Magento\Framework\DataObject;

class OrderEventData extends DataObject implements OrderEventDataInterface
{
    /**
     * @inheritDoc
     */
    public function getIncrementId(): ?string
    {
        return (string)$this->getData(self::ORDER_INCREMENT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setIncrementId(?string $incrementId): void
    {
        $this->setData(self::ORDER_INCREMENT_ID, $incrementId);
    }

    /**
     * @inheritDoc
     */
    public function getOrderStatus(): ?string
    {
        return (string)$this->getData(self::ORDER_STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setOrderStatus(?string $orderStatus): void
    {
        $this->setData(self::ORDER_STATUS, $orderStatus);
    }
}
