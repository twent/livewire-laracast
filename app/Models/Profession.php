<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\EnumToArray;

enum Profession: string
{
    use EnumToArray;

    case Accountant = 'accountant';
    case Actor = 'actor';
    case Actress = 'actress';
    case Architect = 'architect';
    case Artist = 'artist';
    case Banker = 'banker';
    case Bartender = 'bartender';
    case Barber = 'barber';
    case Bookkeeper = 'bookkeeper';
    case Builder = 'builder';
    case Businessperson = 'business_person';
    case Butcher = 'butcher';
    case Cashier = 'cashier';
    case Chef = 'chef';
    case Coach = 'coach';
    case Dentist = 'dentist';
    case Designer = 'designer';
    case Developer = 'developer';
    case Doctor = 'doctor';
    case Economist = 'economist';
    case Editor = 'editor';
    case Electrician = 'electrician';
    case Engineer = 'engineer';
}
