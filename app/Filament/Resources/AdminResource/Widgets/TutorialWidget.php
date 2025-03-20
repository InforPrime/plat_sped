<?php

namespace App\Filament\Resources\AdminResource\Widgets;

use Filament\Widgets\Widget;

class TutorialWidget extends Widget
{
    protected static ?int $sort = 1;
    protected static string $view = 'filament.resources.admin-resource.widgets.tutorial-widget';

    protected int|string|array $columnSpan = 'full';
}
