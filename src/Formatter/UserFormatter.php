<?php

namespace Evaneos\Formatter;

use Evaneos\Entity\Template;
use Evaneos\Entity\User;

class UserFormatter implements FormatterInterface
{
    /**
     * @inheritDoc
     */
    public function isRequirementValid(array $data)
    {
        return (isset($data['user']) and ($data['user'] instanceof User));
    }

    /**
     * @inheritDoc
     */
    public function format(Template $template, array $data)
    {
        /** @var User $user */
        $user = $data['user'];

        $this->replaceTag($template, 'user:first_name', ucfirst(mb_strtolower($user->firstname)));
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