<?php
declare(strict_types=1);

namespace Codexpect\IntegrationTests\Test\Integration;

use Codexpect\IntegrationTests\Model\Configuration;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * @magentoDbIsolation enabled
 */
class AppAreaTest extends TestCase
{
    /**
     * @magentoAppArea frontend
     */
    public function testGetFrontendArea()
    {
        $this->assertEquals('frontend', $this->configuration->getParams()['area']);
    }

    /**
     * @magentoAppArea adminhtml
     */
    public function testGetAdminArea()
    {
        $this->assertEquals('adminhtml', $this->configuration->getParams()['area']);
    }

    protected function setUp(): void
    {
        $objectManager = Bootstrap::getObjectManager();
        $this->configuration = $objectManager->create(Configuration::class);
    }
}

