<?php

namespace App\Contracts\Interface;

use App\Contracts\Interface\Eloquent\DeleteInterface;
use App\Contracts\Interface\Eloquent\GetInterface;
use App\Contracts\Interface\Eloquent\ShowInterface;
use App\Contracts\Interface\Eloquent\StoreInterface;
use App\Contracts\Interface\Eloquent\UpdateInterface;

interface AssignmentInterface extends GetInterface,UpdateInterface,DeleteInterface,ShowInterface,StoreInterface
{
    public function getAssignmentByClassId(mixed $id);

    public function getAverageScore(mixed $id);

    public function getAssignmentByTopic(mixed $id);
}
