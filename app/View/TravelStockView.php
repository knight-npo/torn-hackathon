<?php

namespace NPO\TornHackathon\View;

use NPO\TornHackathon\View\Template\Templater;

class TravelStockView implements View {
    public function render($args) {
        Templater::getInstance()->render("travel_stock.html.twig", $args);
    }
}
