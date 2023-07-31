<?php

namespace Codexpect\IntegrationTests\Model;

use Codexpect\IntegrationTests\Api\Data\ActionHistoryInterface;
use Codexpect\IntegrationTests\Api\Data\ActionHistoryInterfaceFactory;
use Codexpect\IntegrationTests\Model\ResourceModel\ActionHistoryResource;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class ActionHistoryModel extends AbstractModel
{
    protected $_eventPrefix = 'order_action_history_model';
    private ActionHistoryInterfaceFactory $actionHistoryDataFactory;
    private DataObjectHelper $dataObjectHelper;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ActionHistoryInterfaceFactory $actionHistoryDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ActionHistoryInterfaceFactory $actionHistoryDataFactory,
        DataObjectHelper $dataObjectHelper,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->actionHistoryDataFactory = $actionHistoryDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * @return ActionHistoryInterface
     */
    public function getDataModel(): ActionHistoryInterface
    {
        $actionHistoryData = $this->getData();

        $actionHistoryDataObject = $this->actionHistoryDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $actionHistoryDataObject,
            $actionHistoryData,
            ActionHistoryInterface::class
        );

        return $actionHistoryDataObject;
    }

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ActionHistoryResource::class);
    }
}
