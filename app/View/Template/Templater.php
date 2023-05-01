<?php

namespace NPO\TornHackathon\View\Template;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Extension\DebugExtension;

class Templater {
    private static $instance;
    private $twig;
    private function __construct() {
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $loader = new FilesystemLoader('./');
            $loader->addPath('./app/View/Template', 'main');
            $twig = new Environment($loader, [
                'cache' => __DIR__ . '/../../../compilation_cache',
                'debug' => true
            ]);

            $twig->addExtension(new DebugExtension());

            self::$instance = new self();
            self::$instance->twig = $twig;
        }

        return self::$instance;
    }

    public function render($view, $args) {
        echo $this->twig->render("@main/" . $view, $args);
    }
}
