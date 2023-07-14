<?php
declare(strict_types=1);

namespace Codexpect\IntegrationTests\Test\Integration;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * @magentoDbIsolation disabled
 */
class DbIsolationTest extends TestCase
{
    public function testCreateBlock()
    {
        $cmsBlock = $this->cmsBlockFactory->create();
        $cmsBlock->setTitle('My Custom Block');
        $cmsBlock->setContent('<p>This is the content of my custom page.</p>');
        $cmsBlock->setIdentifier('my-custom-block');
        $this->cmsBlockRepository->save($cmsBlock);

        $totalCount = $this->cmsBlockRepository->getList($this->criteriaBuilder->create())->getTotalCount();
        $this->assertEquals(1, $totalCount);
    }

    protected function setUp(): void
    {
        $objectManager = Bootstrap::getObjectManager();
        $this->cmsBlockFactory = $objectManager->create(BlockFactory::class);
        $this->cmsBlockRepository = $objectManager->create(BlockRepositoryInterface::class);
        $this->criteriaBuilder = $objectManager->create(SearchCriteriaBuilder::class);
    }
}

