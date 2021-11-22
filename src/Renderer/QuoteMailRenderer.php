<?php


namespace Evaneos\Renderer;


use Evaneos\Entity\Quote;

class QuoteMailRenderer implements MailRendererInterface
{
    /** @var Quote */
    private $quote;

    public function __construct(Quote $quote)
    {
        $this->quote = $quote;
    }

    /**
     * @inheritDoc
     */
    public function renderHTML()
    {
        return "<p>{$this->quote->id}</p>";
    }

    /**
     * @inheritDoc
     */
    public function renderText()
    {
        return (string) $this->quote->id;
    }

}