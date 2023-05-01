<?php

namespace NPO\TornHackathon\View;

use NPO\TornHackathon\View\Template\Templater;

class PointMarketView implements View {
    public function render($args) {
        Templater::getInstance()->render("points_market.html.twig", $args);
    }
}
