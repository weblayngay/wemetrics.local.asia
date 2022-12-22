<?php

namespace App\Http\Controllers\Api\Self;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Helpers\CryptHelper;
use App\Helpers\JsonHelper;
use App\Helpers\StringHelper;
use App\Helpers\RequestHelper;
use App\Models\ApiIn\CTokenIn;

class AccesstokenController extends BaseController
{
    public function __construct()
    {
        $this->ctokeninModel = new CTokenIn();
        $this->grantType     = 'client_credentials';
        $this->scopes        = 'client_accesstoken';
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function getToken(Request $request)
    {
        $outputFormat = 'Y-m-d';
        $current = date('Y-m-d');
        $current = strtotime($current);
        //
        $rName 			= $request->name;
        $rClientID  	= $request->client_id;
        $rClientKey 	= $request->client_key;
        //
        if(!isset($rClientID))
        {
            return response()->json(
            [
                'message'   => 'Client id không hợp lệ',
                'status'    => 'fail',
                'mode'      => '0',
                'code'		=> '101'
            ]);
        }
        //
        if(!isset($rClientKey))
        {
            return response()->json(
            [
                'message'   => 'Client key không hợp lệ',
                'status'    => 'fail',
                'mode'      => '0',
                'code'		=> '102'
            ]);
        }
        //
        if(!isset($rName))
        {
            return response()->json(
            [
                'message'   => 'Tên ứng dụng không hợp lệ',
                'status'    => 'fail',
                'mode'      => '0',
                'code'		=> '103'
            ]);
        }
        //
		if(isset($rClientID))
		{
			$mClientId = $this->ctokeninModel::query()->where(['client_id' => $rClientID, 'ctokenin_name' => $rName])->first();
			if(empty($mClientId))
			{
	            return response()->json(
	            [
	                'message'   => 'Client id không tồn tại',
	                'status'    => 'fail',
	                'mode'      => '0',
	                'code'		=> '104'
	            ]);
			}
		}
		//
		if(isset($rClientKey))
		{
			$mClientKey = $this->ctokeninModel::query()->where(['client_key' => $rClientKey, 'ctokenin_name' => $rName])->first();
			if(empty($mClientKey))
			{
	            return response()->json(
	            [
	                'message'   => 'Client key không tồn tại',
	                'status'    => 'fail',
	                'mode'      => '0',
	                'code'		=> '105'
	            ]);
			}
		}
		if(isset($rName))
		{
			$mName = $this->ctokeninModel::query()->where(['ctokenin_name' => $rName])->first();
			if(empty($mName))
			{
	            return response()->json(
	            [
	                'message'   => 'Tên ứng dụng không tồn tại',
	                'status'    => 'fail',
	                'mode'      => '0',
	                'code'		=> '106'
	            ]);
			}
		} 
        //
        try
        {
            $Str = $rClientID.';'.$rClientKey.';'.$rName.';'.$current;
            // $result = Hash::make($Str);
            $result = CryptHelper::encryptCombineBase64Sha1($Str);
        }
        catch (Exception $e)
        {
            \DB::rollback(); // Rollback transaction
            return response()->json(
            [
                'message'   => 'Khởi tạo khóa kết nối không thành công',
                'status'    => 'fail',
                'mode'      => '0',
                'code'		=> '100',
                'result'    => ''
            ]);
        }

        return response()->json(
        [
            'message'   => 'Khởi tạo khóa kết nối thành công',
            'status'    => 'success',
            'mode'      => '1',
            'code'		=> '200',
            'result'    => $result
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function verifyToken(Request $request)
    {
        $outputFormat = 'Y-m-d';
        $current = date('Y-m-d');
        $current = strtotime($current);
        //
        $rName 		= $request->name;
        $rClientID  = $request->client_id;
        $rClientKey = $request->client_key;
        $rToken 	= $request->token;
        $rGrantType = $request->grant_type;
        $rScopes    = $request->scopes;
        //
        if(!isset($rClientID))
        {
            return response()->json(
            [
                'message'   => 'Client id không hợp lệ',
                'status'    => 'fail',
                'mode'      => '0',
                'code'		=> '101'
            ]);
        }
        //
        if(!isset($rClientKey))
        {
            return response()->json(
            [
                'message'   => 'Client key không hợp lệ',
                'status'    => 'fail',
                'mode'      => '0',
                'code'		=> '102'
            ]);
        }
        //
        if(!isset($rName))
        {
            return response()->json(
            [
                'message'   => 'Tên ứng dụng không hợp lệ',
                'status'    => 'fail',
                'mode'      => '0',
                'code'		=> '103'
            ]);
        }
        //
		if(isset($rClientID))
		{
			$mClientId = $this->ctokeninModel::query()->where(['client_id' => $rClientID, 'ctokenin_name' => $rName])->first();
			if(empty($mClientId))
			{
	            return response()->json(
	            [
	                'message'   => 'Client id không tồn tại',
	                'status'    => 'fail',
	                'mode'      => '0',
	                'code'		=> '104'
	            ]);
			}
		}
		//
		if(isset($rClientKey))
		{
			$mClientKey = $this->ctokeninModel::query()->where(['client_key' => $rClientKey, 'ctokenin_name' => $rName])->first();
			if(empty($mClientKey))
			{
	            return response()->json(
	            [
	                'message'   => 'Client key không tồn tại',
	                'status'    => 'fail',
	                'mode'      => '0',
	                'code'		=> '105'
	            ]);
			}
		}
		if(isset($rName))
		{
			$mName = $this->ctokeninModel::query()->where(['ctokenin_name' => $rName])->first();
			if(empty($mName))
			{
	            return response()->json(
	            [
	                'message'   => 'Tên ứng dụng không tồn tại',
	                'status'    => 'fail',
	                'mode'      => '0',
	                'code'		=> '106'
	            ]);
			}
		}
		//
        if(!isset($rGrantType) || $rGrantType != $this->grantType)
        {
            return response()->json(
            [
                'message'   => 'Grant type không hợp lệ',
                'status'    => 'fail',
                'mode'      => '0',
                'code'		=> '107'
            ]);
        }
        //
        if(!isset($rScopes) || $rScopes != $this->scopes)
        {
            return response()->json(
            [
                'message'   => 'Scopes không hợp lệ',
                'status'    => 'fail',
                'mode'      => '0',
                'code'		=> '108'
            ]);
        }
        if(!isset($rToken))
        {
            return response()->json(
            [
                'message'   => 'Token không hợp lệ',
                'status'    => 'fail',
                'mode'      => '0',
                'code'      => '109'
            ]);
        }   
        //
        try
        {
            $Str = $rClientID.';'.$rClientKey.';'.$rName.';'.$current;
            $result = CryptHelper::encryptCombineBase64Sha1($Str);
            if ($result == $rToken)
            {
	            return response()->json(
	            [
	                'message'   => 'Token hợp lệ',
	                'status'    => 'success',
	                'mode'      => '0',
	                'code'		=> '200',
	                'result'	=> $result
	            ]);
            }
            else
            {
	            return response()->json(
	            [
	                'message'   => 'Token không hợp lệ',
	                'status'    => 'fail',
	                'mode'      => '0',
	                'code'		=> '100',
	                'result'	=> $result
	            ]);
            }
        }
        catch (Exception $e)
        {
            return response()->json(
            [
	                'message'   => 'Token không hợp lệ',
	                'status'    => 'fail',
	                'mode'      => '0',
	                'code'		=> '100',
	                'result'	=> $result
            ]);
        }
    }


    /**
     * @param jsonIterator
     * @return \Illuminate\Http\Response
     */
    public function verifyTokenJson($jsonIterator)
    {
        $outputFormat = 'Y-m-d';
        $current = date('Y-m-d');
        $current = strtotime($current);
        //
        $arr = JsonHelper::getArrayFromIterator($jsonIterator);
        $obj = new \stdClass();
        $obj = JsonHelper::getObjectFromArray($arr);
        //
        $rName      = $obj->name;
        $rClientID  = $obj->client_id;
        $rClientKey = $obj->client_key;
        $rToken     = $obj->token;
        $rGrantType = $obj->grant_type;
        $rScopes    = $obj->scopes;
        //
        if(!isset($rClientID))
        {
            return response()->json(
            [
                'message'   => 'Client id không hợp lệ',
                'status'    => 'fail',
                'mode'      => '0',
                'code'      => '101'
            ]);
        }
        //
        if(!isset($rClientKey))
        {
            return response()->json(
            [
                'message'   => 'Client key không hợp lệ',
                'status'    => 'fail',
                'mode'      => '0',
                'code'      => '102'
            ]);
        }
        //
        if(!isset($rName))
        {
            return response()->json(
            [
                'message'   => 'Tên ứng dụng không hợp lệ',
                'status'    => 'fail',
                'mode'      => '0',
                'code'      => '103'
            ]);
        }
        //
        if(isset($rClientID))
        {
            $mClientId = $this->ctokeninModel::query()->where(['client_id' => $rClientID, 'ctokenin_name' => $rName])->first();
            if(empty($mClientId))
            {
                return response()->json(
                [
                    'message'   => 'Client id không tồn tại',
                    'status'    => 'fail',
                    'mode'      => '0',
                    'code'      => '104'
                ]);
            }
        }
        //
        if(isset($rClientKey))
        {
            $mClientKey = $this->ctokeninModel::query()->where(['client_key' => $rClientKey, 'ctokenin_name' => $rName])->first();
            if(empty($mClientKey))
            {
                return response()->json(
                [
                    'message'   => 'Client key không tồn tại',
                    'status'    => 'fail',
                    'mode'      => '0',
                    'code'      => '105'
                ]);
            }
        }
        if(isset($rName))
        {
            $mName = $this->ctokeninModel::query()->where(['ctokenin_name' => $rName])->first();
            if(empty($mName))
            {
                return response()->json(
                [
                    'message'   => 'Tên ứng dụng không tồn tại',
                    'status'    => 'fail',
                    'mode'      => '0',
                    'code'      => '106'
                ]);
            }
        }
        //
        if(!isset($rGrantType) || $rGrantType != $this->grantType)
        {
            return response()->json(
            [
                'message'   => 'Grant type không hợp lệ',
                'status'    => 'fail',
                'mode'      => '0',
                'code'      => '107'
            ]);
        }
        //
        if(!isset($rScopes) || $rScopes != $this->scopes)
        {
            return response()->json(
            [
                'message'   => 'Scopes không hợp lệ',
                'status'    => 'fail',
                'mode'      => '0',
                'code'      => '108'
            ]);
        }
        if(!isset($rToken))
        {
            return response()->json(
            [
                'message'   => 'Token không hợp lệ',
                'status'    => 'fail',
                'mode'      => '0',
                'code'      => '109'
            ]);
        }   
        //
        try
        {
            $Str = $rClientID.';'.$rClientKey.';'.$rName.';'.$current;
            $result = CryptHelper::encryptCombineBase64Sha1($Str);
            if ($result == $rToken)
            {
                return response()->json(
                [
                    'message'   => 'Token hợp lệ',
                    'status'    => 'success',
                    'mode'      => '0',
                    'code'      => '200',
                    'result'    => $result
                ]);
            }
            else
            {
                return response()->json(
                [
                    'message'   => 'Token không hợp lệ',
                    'status'    => 'fail',
                    'mode'      => '0',
                    'code'      => '100',
                    'result'    => $result
                ]);
            }
        }
        catch (Exception $e)
        {
            return response()->json(
            [
                    'message'   => 'Token không hợp lệ',
                    'status'    => 'fail',
                    'mode'      => '0',
                    'code'      => '100',
                    'result'    => $result
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function verifyHashHeader(Request $request)
    {  
        //
        try
        {
            $headers = RequestHelper::get_HTTP_request_headers();
            $headers = JsonHelper::getObjectFromArray($headers);
            $mClientId = '';
            $mName = '';
            $mHash = '';
            foreach ($headers as $key => $value) 
            {
                if($key == 'X-Wemetrics-Clientid')
                {
                    $mClientId = $value;
                }

                if($key == 'X-Wemetrics-Name')
                {
                    $mName = StringHelper::wemetrics_remove_non_ascii(base64_decode($value));
                }

                if($key == 'X-Wemetrics-Req-H')
                {
                    $mHash = $value;
                }
            }
            $dataCtokenIn = $this->ctokeninModel::query()->select('client_key')->where(['ctokenin_name' => $mName])->first();
            if(empty($dataCtokenIn))
            {
                return response()->json(
                [
                    'message'   => 'Name không hợp lệ',
                    'reason'    => '',
                    'status'    => 'fail',
                    'mode'      => '0',
                    'code'      => '100',
                    'result'    => ''
                ]);
            }
            $mClientKey = $dataCtokenIn->client_key;
            //
            $body = JsonHelper::getPhpInput();
            $cHash = CryptHelper::encryptCombineBase64Sha256($body, $mClientKey);
            if($cHash == $mHash)
            {
                return response()->json(
                [
                    'message'   => 'Hash hợp lệ',
                    'reason'    => '',
                    'status'    => 'success',
                    'mode'      => '0',
                    'code'      => '200',
                    'result'    => $cHash
                ]);
            }
            else
            {
                return response()->json(
                [
                    'message'   => 'Hash không hợp lệ',
                    'reason'    => '',
                    'status'    => 'fail',
                    'mode'      => '0',
                    'code'      => '100',
                    'result'    => $cHash
                ]);
            }
        }
        catch (Exception $e)
        {
            return response()->json(
            [
                    'message'   => 'Hash không hợp lệ',
                    'reason'    => '',
                    'status'    => 'fail',
                    'mode'      => '0',
                    'code'      => '100',
                    'result'    => $cHash
            ]);
        }
    }
}