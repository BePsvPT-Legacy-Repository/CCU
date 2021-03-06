<?php

namespace App\Ccu\Core;

use App\Ccu\Core\Cache\Rememberable;
use Eloquent;

class Entity extends Eloquent
{
    use Rememberable;

    /**
     * Website version.
     *
     * @var int
     */
    const VERSION = 1.62;

    /**
     * The minutes of a day.
     *
     * @var int
     */
    const CACHE_A_DAY = 1440;

    /**
     * The minutes of a week.
     *
     * @var int
     */
    const CACHE_A_WEEK = 10080;

    /**
     * The minutes of a month.
     *
     * @var int
     */
    const CACHE_A_MONTH = 43200;

    /**
     * Get the table name of this model.
     *
     * @return string
     */
    public static function getTableName()
    {
        return (new static)->getTable();
    }
}
