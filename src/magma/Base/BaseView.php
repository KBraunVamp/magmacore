<?php 

declare(strict_types=1);

namespace Magma\Base;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\FilesystemLoader;
use Magma\Twig\TwigExtension;
use Exception;


class BaseView {
    
    public function getTemplate(string $template, array $context = []) {

        static $twig;
        if ($twig === null) {
            $loader = new FilesystemLoader('templates', TEMPLATES_PATH);
            $twig = new Environment($loader, array());
            $twig->addExtension(new DebugExtension());
            $twig->addExtension(new TwigExtension());
        }
        return $twig->render($template, $context);
    }
}