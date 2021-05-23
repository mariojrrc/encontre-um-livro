<?php

declare(strict_types=1);

namespace App\View\Helper;

use App\Factory\SessionFactory;
use Aura\Session\Segment;
use Laminas\View\Helper\AbstractHelper;

use function sprintf;

class FlashMessenger extends AbstractHelper
{
    public const INFO              = 'info';
    public const ERROR             = 'error';
    public const SUCCESS           = 'success';
    public const DEFAULT    = 'default';
    public const WARNING = 'warning';

    private Segment $segment;
    private array $messages = [];

    protected array $classMessages = [
        self::INFO => 'alert alert-dismissable alert-info',
        self::ERROR => 'alert alert-dismissable alert-danger',
        self::SUCCESS => 'alert alert-dismissable alert-success',
        self::DEFAULT => 'alert alert-dismissable alert-default',
        self::WARNING => 'alert alert-dismissable alert-warning',
    ];

    protected string $messageCloseString = '</li></ul></div>';

    protected string $messageOpenFormat = '<div class="%s">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
         &times;
     </button>
     <ul><li>';

    protected string $messageSeparatorString = '</li><li>';

    public function __construct(Segment $segment)
    {
        $this->segment = $segment;
    }

    public function __invoke(): self
    {
        return $this;
    }

    public function addMessage(string $message, string $type = self::INFO): void
    {
        if (empty($this->messages)) {
            $this->messages = $this->segment->getFlash(SessionFactory::FLASH, []);
        }

        $this->messages[$type][] = $message;
        $this->segment->setFlashNow(SessionFactory::FLASH, $this->messages);
    }

    public function addInfoMessage(string $message): void
    {
        $this->addMessage($message, self::INFO);
    }

    public function addErrorMessage(string $message): void
    {
        $this->addMessage($message, self::ERROR);
    }

    public function addSuccessMessage(string $message): void
    {
        $this->addMessage($message, self::SUCCESS);
    }

    public function addDefaultMessage(string $message): void
    {
        $this->addMessage($message, self::DEFAULT);
    }

    public function addWarningMessage(string $message): void
    {
        $this->addMessage($message, self::WARNING);
    }

    public function render(): string
    {
        $messages = $this->segment->getFlash(SessionFactory::FLASH);
        $this->segment->clearFlashNow();

        if (empty($messages)) {
            return '';
        }

        $html = '';
        foreach ($messages as $type => $list) {
            foreach ($list as $message) {
                $html .= sprintf($this->messageOpenFormat, $this->classMessages[$type]);
                $html .= sprintf('%s%s', $message, $this->messageCloseString);
            }
        }

        return $html;
    }
}
