<?php

namespace Evaneos\Factory;

use Evaneos\Context\ApplicationContext;
use Evaneos\Formatter\QuoteFormatter;
use Evaneos\Formatter\UserFormatter;
use Evaneos\TemplateManager;

class TemplateManagerFactory
{
    static public function buildTemplateManager()
    {
        $applicationContext = ApplicationContext::getInstance();

        $templateManager = new TemplateManager([
            'user' => $applicationContext->getCurrentUser(),
            'site' => $applicationContext->getCurrentSite()
        ]);

        $templateManager->addFormatter(new QuoteFormatter());
        $templateManager->addFormatter(new UserFormatter());

        return $templateManager;
    }
}