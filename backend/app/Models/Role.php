<?php

namespace App\Models;

use App\Traits\HasUlid;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasUlid;
    protected $primaryKey = 'ulid';

    const ADMIN = 'Admin';
}
