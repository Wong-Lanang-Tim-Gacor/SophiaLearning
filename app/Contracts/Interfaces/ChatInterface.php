<?php

namespace App\Contracts\Interfaces;
use App\Contracts\Interfaces\Eloquent\{DeleteInterface, GetInterface, UpdateInterface, StoreInterface, ShowInterface};

interface ChatInterface extends DeleteInterface, UpdateInterface, StoreInterface, ShowInterface, GetInterface {
    public function getChatByResource(mixed $resourceId);
}
