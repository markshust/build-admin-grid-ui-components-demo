<?php declare(strict_types=1);

namespace Macademy\Faq\Controller\Adminhtml\Question;

use Macademy\Faq\Model\Question;
use Macademy\Faq\Model\QuestionFactory;
use Macademy\Faq\Model\ResourceModel\Question as QuestionResource;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Delete extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Macademy_Faq::question_delete';

    /** @var Question */
    protected $question;

    /** @var QuestionFactory */
    protected $questionFactory;

    /** @var QuestionResource */
    protected $questionResource;

    /**
     * Index constructor.
     * @param Context $context
     * @param Question $question
     * @param QuestionFactory $questionFactory
     * @param QuestionResource $questionResource
     */
    public function __construct(
        Context $context,
        Question $question,
        QuestionFactory $questionFactory,
        QuestionResource $questionResource
    ) {
        $this->question = $question;
        $this->questionFactory = $questionFactory;
        $this->questionResource = $questionResource;
        parent::__construct($context);
    }

    /**
     * @return Redirect
     */
    public function execute(): Redirect
    {
        try {
            $id = $this->getRequest()->getParam('id');
            /** @var Question $question */
            $question = $this->questionFactory->create();
            $this->questionResource->load($question, $id);
            if ($question->getId()) {
                $this->questionResource->delete($question);
                $this->messageManager->addSuccessMessage(__('The record has been deleted.'));
            } else {
                $this->messageManager->addErrorMessage(__('The record does not exist.'));
            }

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
