<?php

namespace App\Contracts\Interface;

use App\Contracts\Interface\Eloquent\{DeleteInterface, GetInterface, UpdateInterface, StoreInterface, ShowInterface};

interface ClassroomInterface extends DeleteInterface, UpdateInterface, StoreInterface, ShowInterface, GetInterface {}
