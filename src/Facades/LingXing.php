<?php

namespace ThankSong\LingXing\Facades;
use Illuminate\Support\Facades\Facade;

class LingXing extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'lingxing';
    }
}