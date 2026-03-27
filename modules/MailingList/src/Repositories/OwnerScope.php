<?php

namespace AcMarche\MailingList\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OwnerScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('username', '=', auth()->user()->username);
    }
}
