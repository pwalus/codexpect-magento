<?php
declare(strict_types=1);

namespace Codexpect\IntegrationTests\Test\Integration;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Type;
use Magento\Catalog\Model\ProductFactory;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * @magentoDbIsolation enabled
 */
class DataFixtureTest extends TestCase
{
    public static function createSimpleProduct()
    {
        $objectManager = Bootstrap::getObjectManager();
        $productFactory = $objectManager->create(ProductFactory::class);
        $product = $productFactory->create();
        $product->setTypeId(Type::TYPE_SIMPLE)
            ->setAttributeSetId(4)
            ->setName('Test product')
            ->setSku('simple-test-product')
            ->setPrice(10);

        $productRepository = $objectManager->create(ProductRepositoryInterface::class);
        $productRepository->save($product);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     */
    public function testGetProduct()
    {
        $product = $this->productRepository->get('simple');
        $this->assertEquals('simple', $product->getSku());
    }

    /**
     * @magentoDataFixture createSimpleProduct
     */
    public function testCreateNewProduct()
    {
        $product = $this->productRepository->get('simple-test-product');
        $this->assertEquals('simple-test-product', $product->getSku());
    }

    protected function setUp(): void
    {
        $objectManager = Bootstrap::getObjectManager();
        $this->productRepository = $objectManager->create(ProductRepositoryInterface::class);
    }
}

