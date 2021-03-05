<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repoistory\UserListRepoistory;

class IndexController extends Controller
{
    public function index(){

        $response                    = (object)null;
        $requestData                 = request()->json()->all();

        $userlistRepoistory          = new UserListRepoistory();
        $response->list              = $userlistRepoistory->getUserList($requestData);
        $response->error             = false;
        $response->message           = "";

        return json_encode($response);

    }

    public function addUser(){

        $response                    = (object)null;
        $requestData                 = request()->json()->all();
        $userlistRepoistory          = new UserListRepoistory();
        $data                        = $userlistRepoistory->saveUser($requestData);
        if ( $data['flg'] == true ){
            $response->data          = $data['data'];
            $response->error         = false;
            $response->message       = "";
        }else{
            $response->list          = $data['data'];
            $response->error         = true;
            $response->message       = 'Something went wrong, please try again..!';
        }
        return json_encode($response);

    }

    public function editUser(){

        $response                    = (object)null;
        $requestData                 = request()->json()->all();
        $userlistRepoistory          = new UserListRepoistory();
        if ( isset( $requestData['id'] ) ){
            $data                        = $userlistRepoistory->saveUser($requestData);
            if ( $data['flg'] == true ){
                $response->data          = $data['data'];
                $response->error         = false;
                $response->message       = "";
            }else{
                $response->list          = $data['data'];
                $response->error         = true;
                $response->message       = 'Something went wrong, please try again..!';
            }
        }else{
            $response->list              = [];
            $response->error             = true;
            $response->message           = 'Record id is missing, try again..!';
        }
        return json_encode($response);

    }

    public function userDelete(){

        $response                        = (object)null;
        $requestData                     = request()->json()->all();

        $userlistRepoistory              = new UserListRepoistory();
        if ( isset( $requestData['id'] ) ){
            $userlistRepoistory->deleteUser($requestData);
            $response->error             = false;
            $response->message           = "Record deleted successful..!";    
        }else{
            $response->error             = true;
            $response->message           = 'Record id is missing, try again..!';
        }

        return json_encode($response);

    }

    public function userDetail(){

        $response                        = (object)null;
        $requestData                     = request()->json()->all();

        $userlistRepoistory              = new UserListRepoistory();
        if ( isset( $requestData['id'] ) ){
            $response->data              = $userlistRepoistory->userDetails($requestData);
            if ( count($response->data) ){
                $response->error         = false;
                $response->message       = "";
            }else{
                $response->error         = true;
                $response->message       = "Record is deleted or not found..!";     
            }
        }else{
            $response->error             = true;
            $response->message           = 'Record id is missing, try again..!';
        }

        return json_encode($response);

    }

}
