<?php

namespace Evaneos;

use Evaneos\Entity\Quote;
use Evaneos\Entity\Template;
use Evaneos\Entity\User;
use Evaneos\Repository\DestinationRepository;
use Evaneos\Repository\SiteRepository;

class TemplateManager
{
    /** @var array */
    private $defaultData;

    public function __construct(array $defaultData = [])
    {
        $this->defaultData = $defaultData;
    }

    public function getTemplateComputed(Template $tpl, array $data)
    {
        $replaced = clone($tpl);
        $replaced->subject = $this->computeText($replaced->subject, $data);
        $replaced->content = $this->computeText($replaced->content, $data);

        return $replaced;
    }

    private function computeText($text, array $data)
    {
        $data = array_merge($this->defaultData, $data);

        /*
         * QUOTE
         * [quote:*]
         */
        if (isset($data['quote']) and ($data['quote'] instanceof Quote)) {
            /** @var Quote $quote */
            $quote = $data['quote'];

            $site = SiteRepository::getInstance()->getById($quote->siteId);
            $destination = DestinationRepository::getInstance()->getById($quote->destinationId);

            $text = str_replace('[quote:destination_link]', $site->url . '/' . $destination->countryName . '/quote/' . $quote->id, $text);
            $text = str_replace('[quote:summary_html]', Quote::renderHtml($quote), $text);
            $text = str_replace('[quote:summary]', Quote::renderText($quote), $text);
            $text = str_replace('[quote:destination_name]', $destination->countryName, $text);
        }

        /*
         * USER
         * [user:*]
         */
        if (isset($data['user']) and ($data['user'] instanceof User)) {
            /** @var User $user */
            $user = $data['user'];

            $text = str_replace('[user:first_name]', ucfirst(mb_strtolower($user->firstname)), $text);
        }

        return $text;
    }
}
