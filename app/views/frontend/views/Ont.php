<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ont extends Base_Controller {

	public function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
        $model = array();
        $model['ParentUrl'] = site_url();
        
		$this->load->view($this->router->fetch_class().'/index', $model);
	}

    public function ont_sn_find(){
        header('Content-Type: application/json');

        $returnResult = array();
        $returnResult['result'] = 0;
        $returnResult['msg'] = '';
        $returnResult['data'] = array();
        
        $ONTSN = $this->InputData['ONTSN'];
        if(empty($ONTSN)){
            $returnResult['result'] = 0;
            $returnResult['msg'] = '查詢參數錯誤';
            exit(json_encode($returnResult));
        }

        $get_ONT_Info_ErrMsg = "";
        $ONTInfo = $this->get_ONT_Info($ONTSN, $get_ONT_Info_ErrMsg);
        if($ONTInfo == null){
            $returnResult["result"] = 0;
            $returnResult['msg'] = $get_ONT_Info_ErrMsg;
        }
        else{
            $returnResult["result"] = 1;
            $returnResult['msg'] = "";
            $returnResult['data'] = $ONTInfo;
        }
        
        exit(json_encode($returnResult));
    }

    private function get_ONT_Info($ontsn, &$errMsg){
        {$sr = (
        '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:nbi="http://www.dasannetworks.com/inas/">
            <soapenv:Header>
                <nbi:Authentication xmlns:nbi="http://www.dasannetworks.com/soap/">
                    <userName>test2</userName><password>test2</password>
                </nbi:Authentication>
            </soapenv:Header>
            <soapenv:Body>
                <nbi:CTPRequestInfo>
                    <slotIndex>0</slotIndex>
                    <portIndex>0</portIndex>
                    <onuIdentifier>
                        <searchType>OnuSerial</searchType>
                        <keyWord>'.$ontsn.'</keyWord>
                    </onuIdentifier>
                    <ctpLayerRate>
                        <extVlan>false</extVlan>
                        <uni>false</uni>
                        <ipHost>false</ipHost>
                        <tcont>false</tcont>
                        <mapperGEM>false</mapperGEM>
                        <mcast>false</mcast>
                        <vlanFilter>false</vlanFilter>
                        <rateLimitUni>false</rateLimitUni>
                    </ctpLayerRate>
                    <ipAddress/>
                </nbi:CTPRequestInfo>
            </soapenv:Body>
        </soapenv:Envelope>');}

        $url = "http://10.249.0.121:30521";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $sr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        // var_dump($res);
        if(strpos($res, "ONU with OnuSerial({$ontsn}) is not exist.")) {
            var_dump($res);
            return(null);
        }
        $res = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $res);
        // var_dump($res);
        $xml = new SimpleXMLElement($res);
        $status = $xml->xpath('//soapenvBody/Result/status');
        $statusDesc = $xml->xpath('//soapenvBody/Result/statusDesc');
        // var_dump($statusDesc);
        $objInfo = $xml->xpath('//soapenvBody/CTPResponseInfo/ctpList/ctp');
        // var_dump($objInfo);
        if($objInfo == null){
            $status = json_decode(json_encode((array)$status), TRUE);
            $errMsg .= json_encode($status[0])."\n";
            $statusDesc = json_decode(json_encode((array)$statusDesc), TRUE);
            $errMsg .= json_encode($statusDesc[0])."\n";
            $errMsg .= $res."\n";
            return(null);
        }
        else{
            try {
                if(json_encode((array)$objInfo) === false){
                    throw new Exception( json_last_error() );
                }
                if(json_decode(json_encode((array)$objInfo), TRUE) === false){
                    throw new Exception( json_last_error() );
                }
                $array = json_decode(json_encode((array)$objInfo), TRUE);
            }
            catch(Exception $e ) {
                var_dump($status);
                var_dump($statusDesc);
                var_dump($e);
                var_dump($res);
            }
        }
        return($array[0]);
    }
}
