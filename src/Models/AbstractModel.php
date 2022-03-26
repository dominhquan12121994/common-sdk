<?php

namespace Common\Models;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractModel extends Model
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
