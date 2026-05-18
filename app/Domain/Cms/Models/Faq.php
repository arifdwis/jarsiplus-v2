<?php

namespace App\Domain\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faq';
    protected $fillable = ['uuid', 'label', 'jawaban', 'slug'];
}
