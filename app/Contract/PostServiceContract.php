<?php

namespace App\Contract;

interface PostServiceContract
{
    public function createPostForWebsite(array $data);
    public function sendNewPostNotifications();
}
