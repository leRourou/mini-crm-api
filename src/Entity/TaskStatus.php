<?php

namespace App\Entity;

enum TaskStatus: string
{
    case PENDING = 'prospect';
    case DONE   = 'qualified';
    case CENCELLED    = 'won';
}
