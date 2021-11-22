<?php

namespace Evaneos;

use Evaneos\Entity\Quote;
use Evaneos\Entity\Template;
use Evaneos\Entity\User;
use Evaneos\Formatter\FormatterInterface;
use Evaneos\Repository\DestinationRepository;
use Evaneos\Repository\SiteRepository;

class TemplateManager
{
    /** @var array */
    private $defaultData;

    /** @var FormatterInterface[] */
    private $formatters = [];

    public function __construct(array $defaultData = [])
    {
        $this->defaultData = $defaultData;
    }

    public function addFormatter(FormatterInterface $formatter)
    {
        $this->formatters[] = $formatter;
    }

    public function getTemplateComputed(Template $tpl, array $data)
    {
        $replaced = clone($tpl);

        $this->computeTemplate($replaced, $data);

        return $replaced;
    }

    private function computeTemplate(Template $template, array $data)
    {
        $data = array_merge($this->defaultData, $data);

        /** @var FormatterInterface $formatter */
        foreach ($this->formatters as $formatter) {
            if ($formatter->isRequirementValid($data)) {
                $formatter->format($template, $data);
            }
        }
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
