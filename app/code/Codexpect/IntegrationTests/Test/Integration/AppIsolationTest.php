<?php
declare(strict_types=1);

namespace Codexpect\IntegrationTests\Test\Integration;

use Magento\Framework\Registry;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * @magentoDbIsolation enabled
 * @magentoAppIsolation disabled
 */
class AppIsolationTest extends TestCase
{
    public function testRegisterKey()
    {
        $this->registry->register('test-key', '123');
    }

    public function testEmptyRegistry()
    {
        $product = $this->registry->registry('test-key');
        $this->assertNull($product);
    }

    protected function setUp(): void
    {
        $objectManager = Bootstrap::getObjectManager();
        $this->registry = $objectManager->get(Registry::class);
    }
}

