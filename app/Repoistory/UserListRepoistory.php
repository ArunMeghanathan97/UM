<?php

namespace App\Repoistory;

use Illuminate\Http\Request;
use App\Models\UserList;
use DB;

class UserListRepoistory
{

    public function getUserList($requestData){

        $page                       = ( $requestData['page'] == 0 ? 1 : $requestData['page'] );
        $total                      = 0;
        $offset                     = 0;
        if ( $page > 1 ) $offset    = $page * 10;

        $dataset                    = UserList::where([['id','!=',0]]);
        $dataset                    = $this->getFilterList($dataset,$requestData);
        $dataset                    = $dataset->skip($offset)->take(10)->get();

        if ( !isset( $dataset ) ){
            $dataset                = [];
        }
        $totalset                   = UserList::where([['id','!=',0]]);
        $totalset                   = $this->getFilterList($totalset,$requestData);

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
        if ( isset($requestData['export']) ){
            $list                    = [];
            foreach( $dataset as $k => $v ){
                $list[]             = json_decode(json_encode($v),true);
            }
            $this->download_send_headers("users-" . date("Y-m-d") . ".csv");
            echo $this->array2csv($list);
            die();
        }else{
            return [ 'list' => $dataset, 'page' => $page_lbl, 'page_set' => [ 'page' => $page, 'total' => $total, 'now' =>  ( $offset + count( $dataset ) ) ] ];
        }
    }

    public function getFilterList($dataset,$requestData){

        if ( isset( $requestData['name'] ) ){
            $dataset                = $dataset->Where('name','like','%'.$requestData['name'].'%');
        }
        if ( isset( $requestData['email'] ) ){
            $dataset                = $dataset->Where('email','like','%'.$requestData['email'].'%');
        }
        if ( isset( $requestData['mobile'] ) ){
            $dataset                = $dataset->Where('mobile','like','%'.$requestData['mobile'].'%');
        }
        if ( isset( $requestData['state'] ) ){
            $dataset                = $dataset->Where('state','like','%'.$requestData['state'].'%');
        }
        if ( isset( $requestData['dob'] ) ){
            $dataset                = $dataset->Where('dob','like','%'.$requestData['dob'].'%');
        }
        return $dataset;
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
            $uploadImg              = $this->uploadImg($requestData);
            if ( $uploadImg['flg'] == true ){
                if( count($uploadImg['file']) )
                $dataset->profile_img= $uploadImg['file'][0]['path'];
            }
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

    public function uploadImg($requestData){

        $return     = [];
        $files      = $requestData['profile_img'];
        $date       = date('Ym');
        $folderName = storage_path().'/user_'.$date.'/';
        $next       = 'formshow_'.date('dmY_his');
        if (!file_exists($folderName)){
            mkdir($folderName, 0777, true);
        }

        if (count($files)>0){

            foreach ($files as $k => $v){

                $fil        = explode('base64,', $v['encode']);
                $file       = base64_decode($fil[1]);
                $ext        = $v['ext'];
                file_put_contents($folderName.$next.'.'.$ext, $file) or print_r(error_get_last());
                $fileName   = 'storage/user_'.$date.'/'.$next.'.'.$ext;
                $return[]   = [ 'path' => $fileName, 'name' => $next.'.'.$ext];
            }

        }
        return [ 'flg' => true, 'file' => $return];
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

    function array2csv(array &$array){

        if (count($array) == 0) {
            return null;
        }
        ob_start();
        $df = fopen("php://output", 'w');
        fputcsv($df, array_keys(reset($array)));
        foreach ($array as $row) {
            fputcsv($df, $row);
        }
        fclose($df);
        return ob_get_clean();

    }

    function download_send_headers($filename) {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");
    
        // force download  
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
    
        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }

}
