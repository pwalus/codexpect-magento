<?php
declare(strict_types=1);

namespace Codexpect\IntegrationTests\Model;

enum OrderActions: string
{
    case PLACE = "PLACE";
    case CANCEL = "CANCEL";
    case REFUND = "REFUND";
    case INVOICE = "INVOICE";
    case SHIPPING = "SHIPPING";
}
