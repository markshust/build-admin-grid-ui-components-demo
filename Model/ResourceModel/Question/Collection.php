<?php declare(strict_types=1);

namespace Macademy\Faq\Model\ResourceModel\Question;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Macademy\Faq\Model\Question;

class Collection extends AbstractCollection
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(Question::class, \Macademy\Faq\Model\ResourceModel\Question::class);
    }
}
