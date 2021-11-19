<?php

class TemplateManager
{
    /** @var User */
    private $currentUser;

    /** @var Site */
    private $currentSite;

    public function __construct(Site $currentSite, User $currentUser)
    {
        $this->currentSite = $currentSite;
        $this->currentUser = $currentUser;
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
        $quote = (isset($data['quote']) and $data['quote'] instanceof Quote) ? $data['quote'] : null;

        if ($quote)
        {
            $_quoteFromRepository = QuoteRepository::getInstance()->getById($quote->id);
            $usefulObject = SiteRepository::getInstance()->getById($quote->siteId);
            $destinationOfQuote = DestinationRepository::getInstance()->getById($quote->destinationId);

            $text = str_replace('[quote:destination_link]', $usefulObject->url . '/' . $destinationOfQuote->countryName . '/quote/' . $_quoteFromRepository->id, $text);
            $text = str_replace('[quote:summary_html]', Quote::renderHtml($_quoteFromRepository), $text);
            $text = str_replace('[quote:summary]', Quote::renderText($_quoteFromRepository), $text);
            $text = str_replace('[quote:destination_name]', $destinationOfQuote->countryName,$text);
        }

        /*
         * USER
         * [user:*]
         */
        $_user  = (isset($data['user'])  and ($data['user']  instanceof User))  ? $data['user']  : $this->currentUser;
        $text = str_replace('[user:first_name]', ucfirst(mb_strtolower($_user->firstname)), $text);

        return $text;
    }
}
