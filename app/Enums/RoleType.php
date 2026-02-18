<?php

namespace App\Enums;

enum RoleType: string
{
    case SUPER_ADMIN = 'super-admin';
    case ADMIN = 'admin';
    case MEMBER = 'member';
}
