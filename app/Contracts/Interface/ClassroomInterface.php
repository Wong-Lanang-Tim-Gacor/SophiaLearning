<?php

namespace App\Contracts\Interface;

use App\Contracts\Interface\Eloquent\{DeleteInterface, GetInterface, UpdateInterface, CreateInterface, ShowInterface};

interface ClassroomInterface extends DeleteInterface, UpdateInterface, CreateInterface, ShowInterface, GetInterface {}
