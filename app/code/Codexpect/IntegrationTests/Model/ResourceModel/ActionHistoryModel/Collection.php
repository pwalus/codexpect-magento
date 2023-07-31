<?php

namespace Codexpect\IntegrationTests\Model\ResourceModel\ActionHistoryModel;

use Codexpect\IntegrationTests\Model\ActionHistoryModel;
use Codexpect\IntegrationTests\Model\ResourceModel\ActionHistoryResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'order_action_history_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(ActionHistoryModel::class, ActionHistoryResource::class);
    }
}
