<?php
namespace App\Repositories;

use App\Models\Company;

Class CompanyRepository extends BaseRepository {

public function __construct(Company $company){

    $this->model = $company;

}

}