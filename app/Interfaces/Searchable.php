<?php

namespace App\Interfaces;

interface Searchable
{
    public function scopeSearch($query, $searchData);
}
