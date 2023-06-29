<?php

namespace Codexpect\UnitTests\Api\Data;

interface OrderEventDataInterface
{
    public const ORDER_INCREMENT_ID = "increment_id";
    public const ORDER_STATUS = "order_status";

    /**
     * @return string|null
     */
    public function getIncrementId(): ?string;

    /**
     * @param string|null $incrementId
     *
     * @return void
     */
    public function setIncrementId(?string $incrementId): void;

    /**
     * @return string|null
     */
    public function getOrderStatus(): ?string;

    /**
     * @param string|null $orderStatus
     *
     * @return void
     */
    public function setOrderStatus(?string $orderStatus): void;
}
