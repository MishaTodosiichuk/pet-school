<?php

use App\Managers\IntegrateManagerContacts;
use App\Managers\IntegrateManagerFeedback;
use App\Managers\IntegrateManagerMenu;
use App\Managers\IntegrateManagerNews;
use App\Managers\IntegrateManagerPhotoGallery;

return [
    'modules' => [
        IntegrateManagerMenu::class,
        IntegrateManagerNews::class,
        IntegrateManagerPhotoGallery::class,
        IntegrateManagerContacts::class,
        IntegrateManagerFeedback::class,
    ]
];
