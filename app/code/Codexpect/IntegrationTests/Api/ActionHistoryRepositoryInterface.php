<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Codexpect\IntegrationTests\Api;

use Codexpect\IntegrationTests\Api\Data\ActionHistoryInterface;
use Codexpect\IntegrationTests\Api\Data\ActionHistorySearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

interface ActionHistoryRepositoryInterface
{
    /**
     * Save ActionHistory
     * @param ActionHistoryInterface $actionHistory
     * @return ActionHistoryInterface
     * @throws LocalizedException
     */
    public function save(ActionHistoryInterface $actionHistory): ActionHistoryInterface;

    /**
     * Retrieve ActionHistory
     * @param int $entityId
     * @return ActionHistoryInterface
     * @throws LocalizedException
     */
    public function get(int $entityId): ActionHistoryInterface;

    /**
     * Retrieve ActionHistory matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Delete ActionHistory
     * @param ActionHistoryInterface $actionHistory
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(ActionHistoryInterface $actionHistory): bool;

    /**
     * Delete ActionHistory by ID
     * @param int $entityId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $entityId): bool;
}

