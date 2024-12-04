<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\{DeleteInterface, GetInterface, UpdateInterface, StoreInterface, ShowInterface};

interface ClassroomInterface extends DeleteInterface, UpdateInterface, StoreInterface, ShowInterface, GetInterface {}
