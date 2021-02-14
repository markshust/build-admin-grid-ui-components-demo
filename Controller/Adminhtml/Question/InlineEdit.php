<?php declare(strict_types=1);

namespace Macademy\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Macademy\Faq\Model\QuestionFactory;
use Macademy\Faq\Model\ResourceModel\Question as QuestionResource;

class InlineEdit extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Macademy_Faq::question_save';

    /** @var JsonFactory */
    protected $jsonFactory;

    /** @var QuestionFactory */
    protected $questionFactory;

    /** @var QuestionResource */
    protected $questionResource;

    /**
     * InlineEdit constructor.
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param QuestionFactory $questionFactory
     * @param QuestionResource $questionResource
     */
    public function __construct(
        Context $context,
        QuestionFactory $questionFactory,
        QuestionResource $questionResource,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->questionFactory = $questionFactory;
        $this->questionResource = $questionResource;
    }

    /**
     * Process the request
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $items = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($items))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach ($items as $item) {
            $id = $item['id'];
            try {
                $question = $this->questionFactory->create();
                $this->questionResource->load($question, $id);
                $question->setData(array_merge($question->getData(), $item));
                $this->questionResource->save($question);
            } catch (\Exception $e) {
                $messages[] = __("Something went wrong while saving item $id.");
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error,
        ]);
    }
}
