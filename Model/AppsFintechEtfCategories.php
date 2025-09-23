<?php

namespace Apps\Fintech\Packages\Etf\Categories\Model;

use System\Base\BaseModel;

class AppsFintechEtfCategories extends BaseModel
{
    public $id;

    public $name;

    public $parent_id;

    public $turn_around_time;
}