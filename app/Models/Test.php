<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Test
 *
 * @package App
 * @property string $name
 * @property string $description
*/
class Test extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description'];


}
