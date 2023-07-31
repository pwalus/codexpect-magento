<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Codexpect\IntegrationTests\Model;

use Codexpect\IntegrationTests\Api\ActionHistoryRepositoryInterface;
use Codexpect\IntegrationTests\Api\Data\ActionHistoryInterface;
use Codexpect\IntegrationTests\Api\Data\ActionHistoryInterfaceFactory;
use Codexpect\IntegrationTests\Api\Data\ActionHistorySearchResultsInterface;
use Codexpect\IntegrationTests\Model\ResourceModel\ActionHistoryModel\CollectionFactory as ActionHistoryCollectionFactory;
use Codexpect\IntegrationTests\Model\ResourceModel\ActionHistoryResource as ResourceActionHistory;
use Exception;
use Magento\Framework\Api\Search\SearchResultFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;

class ActionHistoryRepository implements ActionHistoryRepositoryInterface
{
    private ResourceActionHistory $resource;
    private ActionHistoryModelFactory $actionHistoryModelFactory;
    private ActionHistoryInterfaceFactory $dataActionHistoryFactory;
    private ActionHistoryCollectionFactory $actionHistoryCollectionFactory;
    private SearchResultFactory $searchResultsFactory;
    private CollectionProcessorInterface $collectionProcessor;
    private DataObjectProcessor $dataObjectProcessor;

    /**
     * @param ResourceActionHistory $resource
     * @param ActionHistoryModelFactory $actionHistoryModelFactory
     * @param ActionHistoryInterfaceFactory $dataActionHistoryFactory
     * @param ActionHistoryCollectionFactory $actionHistoryCollectionFactory
     * @param SearchResultFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param DataObjectProcessor $dataObjectProcessor
     */
    public function __construct(
        ResourceActionHistory $resource,
        ActionHistoryModelFactory $actionHistoryModelFactory,
        ActionHistoryInterfaceFactory $dataActionHistoryFactory,
        ActionHistoryCollectionFactory $actionHistoryCollectionFactory,
        SearchResultFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->resource = $resource;
        $this->actionHistoryModelFactory = $actionHistoryModelFactory;
        $this->dataActionHistoryFactory = $dataActionHistoryFactory;
        $this->actionHistoryCollectionFactory = $actionHistoryCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    /**
     * @inheritdoc
     */
    public function save(ActionHistoryInterface $actionHistory): ActionHistoryInterface
    {
        try {
            $actionHistoryData = $this->dataObjectProcessor->buildOutputDataArray(
                $actionHistory,
                ActionHistoryInterface::class
            );
            unset($actionHistoryData[ActionHistoryInterface::CREATED_AT]);

            /** @var ActionHistoryModel $actionHistoryModel */
            $actionHistoryModel = $this->actionHistoryModelFactory->create(['data' => $actionHistoryData]);
            $actionHistoryModel->setDataChanges(true);

            $this->resource->save($actionHistoryModel);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the actionHistory: %1',
                $exception->getMessage()
            ));
        }
        return $this->get((int)$actionHistoryModel->getId());
    }

    /**
     * @inheritdoc
     */
    public function get(int $entityId): ActionHistoryInterface
    {
        $actionHistory = $this->actionHistoryModelFactory->create();
        $this->resource->load($actionHistory, $entityId);
        if (!$actionHistory->getId()) {
            throw new NoSuchEntityException(__('ActionHistory with id "%1" does not exist.', $entityId));
        }
        return $actionHistory->getDataModel();
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->actionHistoryCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritdoc
     */
    public function deleteById(int $entityId): bool
    {
        return $this->delete($this->get($entityId));
    }

    /**
     * @inheritdoc
     */
    public function delete(ActionHistoryInterface $actionHistory): bool
    {
        try {
            $actionHistoryModel = $this->actionHistoryModelFactory->create();
            $this->resource->load($actionHistoryModel, $actionHistory->getId());
            $this->resource->delete($actionHistoryModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the ActionHistory: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }
}
