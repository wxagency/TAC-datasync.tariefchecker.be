<?php

namespace App\Console\Commands\Restore;
use App\Models\History\BackupDate;

/**
 * 
 * 
 * $json = $this->get('Suppliers', $query,[
 *                  'error' => function($ex,$data){
 *                      dd($data);
 *                  }
 *              ]);
 */
trait AirtableTrait
{

    /**
     * Api post request
     */
    function post($url, $data, $extras = [], $base = null)
    {
        return $this->request($url, $data, $extras, 'post', $base);
    }

    /**
     * Api get request
     */
    function get($url, $data, $extras = [], $base = null)
    {
        return $this->request($url, $data,  $extras, 'get', $base);
    }

    /**
     * Api update request
     */
    function patch($url, $data, $extras = [], $base = null)
    {
        return $this->request($url, $data, $extras, 'patch', $base);
    }

    /**
     * Api delete request
     */
    function delete($url, $data, $extras = [], $base = null)
    {
        return $this->request($url, $data, $extras, 'delete', $base);
    }

    /**
     * to get the api url
     */
    function getBasuUrl($base = null)
    {
        return $base ? $base :  'https://api.airtable.com/v0/applSCRl4UvL2haqK/';
    }

    /**
     * common function for all the request.
     */
    function request($url, $data, $extras = [], $method = 'post', $base = null)
    {
        $method = strtolower($method);
        $url = $this->getBasuUrl($base) . $url;
        $client = new \GuzzleHttp\Client();
        $success = array_get($extras, 'success', null);
        $error = array_get($extras, 'error', null);
        $query = array_get($extras, 'query', false);
        $requestData = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer keySZo45QUBRPLwjL'
            ],

        ];
        if ($query != false) {
            $requestData[$query] = $data;
        } else if ($method == 'get' || $method == 'delete') {
            $requestData['query'] = $data;
        } else {
            $requestData['json'] = $data;
        }
        try {
            $request = $client->{$method}(
                $url,
                $requestData
            );
        } catch (\Exception $ex) {
            
           if( method_exists($this, 'info')){
                $this->info("Error: ".$ex->getMessage());
           }
            
            if ($error && is_callable($error)) {
                $error($ex, $data);
            }
            return false;
        }
        $response = $request->getBody()->getContents();
        $json = json_decode($response, true);
        if ($success && is_callable($success)) {
            $success($json);
        }
        return $json;
    }

    /**
     * 1.Integer value fields in mysql are represented as string value in Airtable.
     * 2.select option cannot be empty. Either it should contain value or null.
     */
    function get_value($value, $default = null)
    {
        return strlen(strval($value)) > 0 ? strval($value) : $default;
    }

     /**
     * 1.Integer value fields in mysql are represented as string value in Airtable.
     * 2.select option cannot be empty. Either it should contain value or null.
     */
    function getValue($value, $default = null)
    {
        return strlen(strval($value)) > 0 ? strval($value) : $default;
    }


    function formatPrice($value, $default = null){
        $value = $this->getValue($value,  $default);
        if( $value === $default){
            return $default;
        }
        $value = str_replace(".",",",$value);
        $value = preg_replace('/\.(?=.*\.)/', '', $value);
        return $value;
    }

    function formatDate($value, $default = null, $format = 'd/m/Y') {
        if($value){
            return date($format, strtotime($value));
        }
        return $default;
    }

    function dateFormat($value, $default = null, $format = 'm/d/Y') {
        if($value){
            return date($format, strtotime($value));
        }
        return $default;
    }

    function dateStructureFormat($value, $default = null, $format = 'D, d M Y H:i:s') {
        if($value){
            return date($format, strtotime($value));
        }
        return $default;
    }


    function getRestoreDate(){
        $activeRestore = BackupDate::where('status' , 1)->first();
        return $activeRestore ? $activeRestore->backupdate : false;
    }
}
