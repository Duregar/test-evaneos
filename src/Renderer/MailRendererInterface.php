<?php

namespace Evaneos\Renderer;

interface MailRendererInterface
{
    /**
     * @return string
     */
    public function renderHTML();

    /**
     * @return string
     */
    public function renderText();
}