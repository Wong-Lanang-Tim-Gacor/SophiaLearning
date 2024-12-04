<?php

namespace App\Contracts\Interfaces\Eloquent;

interface StoreInterface
{
    public function create(array $data);
}
