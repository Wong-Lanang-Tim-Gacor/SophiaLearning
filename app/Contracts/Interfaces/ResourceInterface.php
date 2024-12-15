<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;

interface ResourceInterface extends GetInterface, UpdateInterface, DeleteInterface, ShowInterface, StoreInterface
{
    public function getResourceByClassId(mixed $id);

    public function getAveragePoint(mixed $id);

    public function getAnnouncements(mixed $id);

    public function getMaterials(mixed $id);

    public function getAssignments(mixed $id);

    public function getUserAssignments(mixed $id);

    public function getAnswersByResource(mixed $id);
}
