<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

#[Fillable(['name', 'species', 'description','status', 'city','photo','approval_status','user_id'])]

    
class Pet extends Model
{
    #[Scope]
    protected function approvalStatus(Builder $query, string $type): void
    {
        $query->where('approval_status', $type);
    }

    #[Scope]
    protected function status(Builder $query, string $type): void
    {
        $query->where('status', $type);
    }
}
