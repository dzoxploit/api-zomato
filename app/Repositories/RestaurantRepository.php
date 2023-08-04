<?php
// app/Repositories/RestaurantRepository.php

namespace App\Repositories;

use App\Models\Restaurant;

class RestaurantRepository
{
    public function searchByName($name)
    {
        return Restaurant::where('name', 'like', "%$name%")->get();
    }

    // Other methods for menus, reviews, etc.
}
