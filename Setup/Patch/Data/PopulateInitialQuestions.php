<?php declare(strict_types=1);

namespace Macademy\Faq\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\App\ResourceConnection;
use Macademy\Faq\Model\ResourceModel\Question;

class PopulateInitialQuestions implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface */
    protected $moduleDataSetup;

    /** @var ResourceConnection */
    protected $resource;

    /**
     * PopulateInitialQuestions constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param ResourceConnection $resource
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ResourceConnection $resource
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->resource = $resource;
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function apply(): self
    {
        $connection = $this->resource->getConnection();
        $connection->insertMultiple(Question::MAIN_TABLE, [
            ['name' => 'What is your best selling item?', 'is_published' => 1],
            ['name' => 'What is your customer support number?', 'is_published' => 1],
            ['name' => 'When will I get my order?', 'is_published' => 0],
        ]);

        return $this;
    }
}
