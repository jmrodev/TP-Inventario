<?php

namespace App\Core;

interface MenuRendererInterface {
    public function render(string $title, array $options): void;
}
