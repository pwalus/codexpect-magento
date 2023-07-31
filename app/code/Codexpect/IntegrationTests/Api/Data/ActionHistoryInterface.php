<?php

namespace Codexpect\IntegrationTests\Api\Data;

interface ActionHistoryInterface
{
    public const ID = "id";
    public const ORDER_ID = "order_id";
    public const ACTION = "action";
    public const CREATED_AT = "created_at";

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return int
     */
    public function getOrderId(): int;

    /**
     * @param int $orderId
     *
     * @return void
     */
    public function setOrderId(int $orderId): void;

    /**
     * @return string
     */
    public function getAction(): string;

    /**
     * @param string $action
     *
     * @return void
     */
    public function setAction(string $action): void;

    /**
     * @return string
     */
    public function getCreatedAt(): string;
}
