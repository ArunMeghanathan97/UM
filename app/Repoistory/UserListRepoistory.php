<?php

namespace App\Repoistory;

use Illuminate\Http\Request;
use App\Models\UserList;

class UserListRepoistory
{
    
    public function getUserList($requestData){

        $page                       = ( $requestData['page'] == 0 ? 1 : $requestData['page'] );
        $total                      = 0;
        $offset                     = 0;
        if ( $page > 1 ) $offset    = $page * 10;
        $filterlist                 = [];

        $dataset                    = UserList::skip($offset)->take(10)->get();
        if ( !isset( $dataset ) ){
            $dataset                = [];
        }

        $totalset                   = UserList::where([['id','!=',0]]);
        // if ( $fromdate != '' && $todate != '' ){
        //     $totalset->whereBetween('created_at',[$fromdate,$todate]);
        // }
        $totalset                   = $totalset->orderBy('updated_at','desc')->get();
        if ( isset($totalset) ){
            $total                  = $total + count( $totalset );
        }

        $page_lbl                   = "page";
        if ( count( $dataset ) > 0 ){
            if ( $offset > 0 ){
                $page_lbl            =  ($offset)." to " . ( $offset + count( $dataset ) ) . " of " .$total;
            }else{
                $page_lbl            =  "1 to " . ( $offset + count( $dataset ) ) . " of " .$total;
            }
        }

        return [ 'list' => $dataset, 'page' => $page_lbl, 'page_set' => [ 'page' => $page, 'total' => $total, 'now' =>  ( $offset + count( $dataset ) ) ] ];
    }

    public function getFilterList($requestData){

        $return                     = [];
        if ( isset( $requestData['username'] ) ){
            $return[]               = [ 'username', '=', $requestData['username'] ];
        }
        if ( isset( $requestData['email'] ) ){
            $return[]               = [ 'email', '=', $requestData['email'] ];
        }
        if ( isset( $requestData['email'] ) ){
            $return[]               = [ 'email', '=', $requestData['email'] ];
        }

    }

    public function saveUser($requestData)
    {

        if ( !isset($requestData['id']) ){
            $dataset                = new UserList();
        }else{
            $dataset                = UserList::find($requestData['id']);
        }
        if( isset($requestData['name']) ){
            $dataset->name          = $requestData['name'];
        }
        if( isset($requestData['username']) ){
            $dataset->username      = $requestData['username'];
        }
        if( isset($requestData['email']) ){
            $dataset->email         = $requestData['email'];
        }
        if( isset($requestData['mobile']) ){
            $dataset->mobile        = $requestData['mobile'];
        }
        if( isset($requestData['profile_img']) ){
            $dataset->profile_img   = $requestData['profile_img'];
        }
        if( isset($requestData['dob']) ){
            $dataset->dob           = $requestData['dob'];
        }
        if( isset($requestData['address']) ){
            $dataset->address       = $requestData['address'];
        }
        if( isset($requestData['city']) ){
            $dataset->city          = $requestData['city'];
        }
        if( isset($requestData['state']) ){
            $dataset->state         = $requestData['state'];
        }
        if( isset($requestData['country']) ){
            $dataset->country       = $requestData['country'];
        }
        $dataset->save();

        if ( isset($dataset->id) ){
            return [ 'flg' => true,'data' =>  UserList::find($dataset->id)];
        }else{
            return [ 'flg' => false, 'data' => [] ];
        }

    }

    public function userDetails($requestData){

        $id                         = $requestData['id'];
        $dataset                    = UserList::find($id);
        if ( isset($dataset) ){
            return $dataset;
        }else{
            return [];
        }

    }

    public function deleteUser($requestData){

        $id                         = $requestData['id'];
        $dataset                    = UserList::find($id);
        if ( !is_null($dataset) ){
            $dataset->delete();
        }

    }

}
