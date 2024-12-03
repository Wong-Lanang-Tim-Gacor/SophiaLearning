<?php

namespace App\Contracts\Interface;

use App\Contracts\Interface\Eloquent\DeleteInterface;
use App\Contracts\Interface\Eloquent\GetInterface;
use App\Contracts\Interface\Eloquent\ShowInterface;
use App\Contracts\Interface\Eloquent\StoreInterface;
use App\Contracts\Interface\Eloquent\UpdateInterface;

interface AssignmentChatInterface extends UpdateInterface,DeleteInterface,ShowInterface,StoreInterface
{
    public function get(mixed $assignmentId);
}
