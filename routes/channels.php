<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('turn.{rootId}', function ($rootId) {
    return true;
});

Broadcast::channel('comment.{rootId}', function ($rootId) {
    return true;
});
