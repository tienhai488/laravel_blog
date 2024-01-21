<?php

use App\Enum\PostStatusEnum;

function getButtonPostStatus($status)
{
    if ($status == PostStatusEnum::PENDING) {
        echo '<button class="btn btn-warning">PENDING</button>';
    } elseif ($status == PostStatusEnum::APPROVED) {
        echo '<button class="btn btn-info">APPROVED</button>';
    } elseif ($status == PostStatusEnum::DENIED) {
        echo '<button class="btn btn-danger">DENIED</button>';
    }
}