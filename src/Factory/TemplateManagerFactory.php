<?php

namespace Evaneos\Factory;

use Evaneos\Context\ApplicationContext;
use Evaneos\TemplateManager;

class TemplateManagerFactory
{
    static public function buildTemplateManager()
    {
        $applicationContext = ApplicationContext::getInstance();

        return new TemplateManager([
            'user' => $applicationContext->getCurrentUser(),
            'site' => $applicationContext->getCurrentSite()
        ]);
    }
}