<?php
namespace BtyBugHook\ApiUser\Repository;

use Btybug\btybug\Repositories\GeneralRepository;
use BtyBugHook\ApiUser\Models\SocialAccount;

class SocialAccountRepository extends GeneralRepository
{
    /**
     * @return mixed
     */

    protected function model()
    {
        return new SocialAccount();
    }

}