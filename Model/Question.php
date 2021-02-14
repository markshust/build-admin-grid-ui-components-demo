<?php declare(strict_types=1);

namespace Macademy\Faq\Model;

use Magento\Framework\Model\AbstractModel;

class Question extends AbstractModel
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Question::class);
    }
}
