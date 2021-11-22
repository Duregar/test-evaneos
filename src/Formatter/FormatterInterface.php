<?php

namespace Evaneos\Formatter;

use Evaneos\Entity\Template;

interface FormatterInterface
{
    /**
     * @param array $data
     * @return bool
     */
    public function isRequirementValid(array $data);

    /**
     * @param Template $template
     * @param array $data
     * @return void
     */
    public function format(Template $template, array $data);
}