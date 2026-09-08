<?php

namespace App\Controller;

abstract class AbstractController
{
    protected function renderView(string $template, array $data = []): string
    {
        $templatePath = dirname(__DIR__, 2) . '/templates/' . $template . '.php';

        if (!is_file($templatePath)) {
            throw new \RuntimeException("Vue introuvable : {$template}");
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $templatePath;
        $content = ob_get_clean();

        ob_start();
        require dirname(__DIR__, 2) . '/templates/layout/base.php';
        return (string) ob_get_clean();
    }
}
