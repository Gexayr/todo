<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = ['author_id', 'title', 'deadline', 'description', 'status', 'performers'];
}
