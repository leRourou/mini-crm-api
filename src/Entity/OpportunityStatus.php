<?php

namespace App\Entity;

enum OpportunityStatus: string
{
    case PROSPECT   = 'prospect';
    case QUALIFIED  = 'qualified';
    case WON        = 'won';
    case LOST       = 'lost';
}
