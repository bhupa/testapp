<?php
namespace App\Repositories;

use App\Models\User;

Class UserRepository extends BaseRepository {

public function __construct(User $user){

    $this->model = $user;

}

}