<?php

namespace Evaneos\Formatter;

use Evaneos\Entity\Template;

abstract class AbstractTagFormatter implements FormatterInterface
{
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