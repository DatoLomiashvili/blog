<?php

namespace App\Enums;

enum Role: string
{
    case admin = "admin";
    case editor = "editor";
    case user = "user";
}
