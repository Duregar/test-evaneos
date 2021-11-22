<?php

namespace Evaneos;

use Evaneos\Entity\Template;
use Evaneos\Formatter\FormatterInterface;

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
}
