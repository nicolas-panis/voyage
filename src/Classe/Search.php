<?php

namespace App\Classe;

use App\Entity\Categories;

class Search
{
    /**
     * @var string
     */
    public $string = '';

    /**
     * @var string
     */
    public $pays = '';

    /**
     * @var Categories[]
     */
    public $category = [];
}