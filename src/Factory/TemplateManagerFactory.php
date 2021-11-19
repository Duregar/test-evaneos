<?php


class TemplateManagerFactory
{
    static public function buildTemplateManager()
    {
        $applicationContext = ApplicationContext::getInstance();

        return new TemplateManager($applicationContext->getCurrentSite(), $applicationContext->getCurrentUser());
    }
}