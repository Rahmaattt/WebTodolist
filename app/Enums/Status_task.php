<?php

namespace App\Enums;

enum Status_task: string
{
    case SELESAI = 'selesai';
    case BELUM_SELESAI = 'belum_selesai';
    case TERLAMBAT = 'terlambat';
}
