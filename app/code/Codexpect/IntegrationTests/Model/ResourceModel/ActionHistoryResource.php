<?php

namespace Codexpect\IntegrationTests\Model\ResourceModel;

use Codexpect\IntegrationTests\Api\Data\ActionHistoryInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class ActionHistoryResource extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'order_action_history_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('order_action_history', ActionHistoryInterface::ID);
        $this->_useIsObjectNew = true;
    }
}
