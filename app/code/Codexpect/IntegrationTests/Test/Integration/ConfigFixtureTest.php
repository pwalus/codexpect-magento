<?php
declare(strict_types=1);

namespace Codexpect\IntegrationTests\Test\Integration;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * @magentoDbIsolation enabled
 * @magentoAppIsolation enabled
 */
class ConfigFixtureTest extends TestCase
{
    /**
     * @magentoDataFixture Magento/Store/_files/multiple_websites_with_store_groups_stores.php
     * @magentoConfigFixture default/dev/restrict/allow_ips 999.999.999.999
     * @magentoConfigFixture current_store dev/restrict/allow_ips 111.111.111.111
     * @magentoConfigFixture third_store_store dev/restrict/allow_ips 222.222.222.222
     * @magentoConfigFixture admin_store dev/restrict/allow_ips 333.333.333.333
     */
    public function testGetConfig()
    {
        $value = $this->config->getValue('dev/restrict/allow_ips');
        $this->assertEquals('999.999.999.999', $value);

        $value = $this->config->getValue('dev/restrict/allow_ips', ScopeInterface::SCOPE_STORE, 1);
        $this->assertEquals('111.111.111.111', $value);

        $value = $this->config->getValue('dev/restrict/allow_ips', ScopeInterface::SCOPE_STORE, 'third_store');
        $this->assertEquals('222.222.222.222', $value);

        $value = $this->config->getValue('dev/restrict/allow_ips', ScopeInterface::SCOPE_STORE, 0);
        $this->assertEquals('333.333.333.333', $value);
    }

    protected function setUp(): void
    {
        $objectManager = Bootstrap::getObjectManager();
        $this->config = $objectManager->get(ScopeConfigInterface::class);
    }
}

