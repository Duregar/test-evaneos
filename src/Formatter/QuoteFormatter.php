<?php

namespace Evaneos\Formatter;

use Evaneos\Entity\Quote;
use Evaneos\Entity\Template;
use Evaneos\Repository\DestinationRepository;
use Evaneos\Repository\SiteRepository;

class QuoteFormatter implements FormatterInterface
{
    /**
     * @inheritDoc
     */
    public function isRequirementValid(array $data)
    {
        return (isset($data['quote']) and ($data['quote'] instanceof Quote));
    }

    /**
     * @inheritDoc
     */
    public function format(Template $template, array $data)
    {
        /** @var Quote $quote */
        $quote = $data['quote'];

        $site = SiteRepository::getInstance()->getById($quote->siteId);
        $destination = DestinationRepository::getInstance()->getById($quote->destinationId);

        $this->replaceTag($template, 'quote:destination_link', $site->url . '/' . $destination->countryName . '/quote/' . $quote->id);
        $this->replaceTag($template, 'quote:summary_html', Quote::renderHtml($quote));
        $this->replaceTag($template, 'quote:summary', Quote::renderText($quote));
        $this->replaceTag($template, 'quote:destination_name', $destination->countryName);
    }

    /**
     * @param Template $template
     * @param string $tag
     * @param string $replacement
     */
    protected function replaceTag(Template $template, $tag, $replacement)
    {
        $template->subject = str_replace("[$tag]", $replacement, $template->subject);
        $template->content = str_replace("[$tag]", $replacement, $template->content);
    }
}