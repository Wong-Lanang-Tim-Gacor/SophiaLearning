<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\{DeleteInterface, GetInterface, UpdateInterface, StoreInterface, ShowInterface};

interface ClassroomInterface extends DeleteInterface, UpdateInterface, StoreInterface, ShowInterface, GetInterface
{
    public function joinClass(string $classroomCode, mixed $userId);
    public function leaveClass(int $classroomId, mixed $userId);
    public function getJoinedClasses(mixed $userId);
    public function getCreatedClasses(mixed $userId);
}
