<?php

namespace Evaneos\Formatter;

use Evaneos\Entity\Template;
use Evaneos\Entity\User;

class UserFormatter extends AbstractTagFormatter
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
}