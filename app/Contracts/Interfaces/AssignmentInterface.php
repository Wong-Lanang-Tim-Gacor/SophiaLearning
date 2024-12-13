<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface AssignmentInterface extends GetInterface,UpdateInterface,DeleteInterface,ShowInterface,StoreInterface
{
    public function getAssignmentByClassId(mixed $id);

    public function getAveragePoint(mixed $id);
}
