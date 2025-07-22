<?php

namespace App\Entity;

enum TaskStatus: string
{
    case PENDING = 'pending';
    case DONE   = 'done';
    case CANCELLED    = 'cancelled';
}
