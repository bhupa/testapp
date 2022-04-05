<?php

namespace App\Http\Controllers;

use App\Http\Requests\Compnay\CompanyStoreRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\UsersResource;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    //

    public function __construct(CompanyRepository $company,UserRepository $user)
    {
        $this->company = $company;
        $this->user = $user;
    }

    public function store(CompanyStoreRequest $request){
         
        $data = $request->except('_token','user');

          $company = $this->company->create($data);
 
          foreach($request->user as $value){
             $user [] = [
                 'company_id'=>$company->id,
                 'name'=>$value
             ];
          }
          
          $this->user->insert($user);

          $data = [
              'success'=>true,
              'body'=> new CompanyResource($company)
          ];
          return response()->json($data);
      
    }
    public function search(Request $request){
      
        $data = request()->get('name');

        $httpClient = new \GuzzleHttp\Client();
        $request =
            $httpClient
                ->get("https://demo.tradeinsur.com/api/v2/companies/filter/?search=".$data);

        $response = json_decode($request->getBody()->getContents());
        $resps = $response->payload;

          foreach($resps as $key=>$value){

              $compData = $this->company->where('name',$value->company_name)->first();
              $respsOutput= $value;
             if($compData){
                $respsOutput->comp_name= $compData->name;
                $respsOutput->comp_siren= $compData->siren;
                $respsOutput->comp_siren= $compData->siret;
                $respsOutput->comp_users= UsersResource::collection($compData->users);
               
             }
              $output[] = $respsOutput;
          }

          return response()->json(['Success'=>true,'Body'=>$output]);
      
        
    }
}
