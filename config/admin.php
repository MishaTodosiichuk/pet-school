<?php

use App\Managers\IntegrateManagerMenu;
use App\Managers\IntegrateManagerNews;
use App\Managers\IntegrateManagerPhotoGallery;

return [
    'modules' => [
        IntegrateManagerMenu::class,
        IntegrateManagerNews::class,
        IntegrateManagerPhotoGallery::class,
    ]
];
