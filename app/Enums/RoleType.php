<?php

namespace App\Enums;

enum RoleType: string
{
    case SUPER_ADMIN = 'super-admin';
    case EDM_ADMIN = 'edm-admin';
    case EDM_MEMBER = 'edm-member';
}
