<?php

namespace App\Broadcasting;

use App\Model\User;

class TestChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Model\User  $user
     * @return array|bool
     */
    public function join(User $user)
    {
        //
    }
}
