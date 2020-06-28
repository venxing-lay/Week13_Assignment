<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
*  @SWG\Definition(
*     definition="Category",
*     required={"label", "name"},
*      @SWG\Property(
*           property="id",
*           description="id",
*           type="integer",
*           format="int32"
*       ),
*      @SWG\Property(
*           property="name",
*           description="name",
*           type="string",
*       ),
*      @SWG\Property(
*           property="created at",
*           description="created at",
*           type="string",
*           format="date-time",
*       ),
*      @SWG\Property(
*           property="updated at",
*           description="updated at",
*           type="string",
*           format="date-time",
*       ),              
* )
*/
class Category extends Model
{
    protected $fillable = [
        "name"
    ];
}
