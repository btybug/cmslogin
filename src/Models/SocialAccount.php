<?php
/**
 * Created by PhpStorm.
 * User: menq
 * Date: 14.03.2018
 * Time: 11:47
 */

namespace BtyBugHook\ApiUser\Models;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $table = 'social_account';

    protected $guarded = ['id'];

}