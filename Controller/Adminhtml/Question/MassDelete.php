<?php declare(strict_types=1);

namespace Macademy\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Macademy\Faq\Model\ResourceModel\Question\CollectionFactory;

class MassDelete extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Macademy_Faq::question_delete';

    /** @var CollectionFactory */
    protected $collectionFactory;

    /** @var Context */
    protected $context;

    /** @var Filter */
    protected $filter;

    /**
     * Index constructor.
     * @param CollectionFactory $collectionFactory
     * @param Context $context
     * @param Filter $filter
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Context $context,
        Filter $filter
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->filter = $filter;
        parent::__construct($context);
    }

    /**
     * @return Redirect
     * @throws LocalizedException
     */
    public function execute(): Redirect
    {
        $collection = $this->collectionFactory->create();
        $items = $this->filter->getCollection($collection);
        $itemsSize = $items->getSize();

//        if ($this->getRequest()->getParam('excluded') === "false") {
//            // This is ran if all items are selected
//            $items = $collection->getFilter();
//        }

        foreach ($items as $item) {
//            $item->delete();
        }

        echo '<pre>';
        var_dump($items->getAllIds());
        die();

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $itemsSize));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
