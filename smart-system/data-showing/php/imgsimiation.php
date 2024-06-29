<?php

$tmp_name = $_FILES['image']['tmp_name'];
$image_data = file_get_contents($tmp_name);
$base64_image = base64_encode($image_data);

class Sample {
    const API_KEY = "NWXbuGcPdhmrDaoJojhVaFnF";
    const SECRET_KEY = "UZAAPYnkiemPSsDy09HeutPiXfyExAuO";

    private $base64_image;
    public function __construct($base64_image) {
        $this->base64_image = $base64_image;
    }

    public function run() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://aip.baidubce.com/rest/2.0/image-classify/v1/animal?access_token={$this->getAccessToken()}",
            CURLOPT_TIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_SSL_VERIFYHOST  => false,
            CURLOPT_CUSTOMREQUEST => 'POST',
            // image 可以通过 $this.getFileBase64Content("C:\fakepath\1.png") 方法获取
            CURLOPT_POSTFIELDS => http_build_query(array(
            //$this->getFileContentAsBase64("$tmp_name"),
            'image' => $this->base64_image,
    )),
    
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Accept: application/json'
            ),

        ));
        //echo "文件数据：" . $base64_image ."<br>";
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    
    /**
     * 获取文件base64编码
     * @param string  $path 文件路径
     * @return string base64编码信息，不带文件头
     */
    private function getFileContentAsBase64($path){
        
          return base64_encode(file_get_contents($path));
        
    }
    
    /**
     * 使用 AK，SK 生成鉴权签名（Access Token）
     * @return string 鉴权签名信息（Access Token）
     */
    private function getAccessToken(){
        $curl = curl_init();
        $postData = array(
            'grant_type' => 'client_credentials',
            'client_id' => self::API_KEY,
            'client_secret' => self::SECRET_KEY
        );
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://aip.baidubce.com/oauth/2.0/token',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_SSL_VERIFYHOST  => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => http_build_query($postData)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $rtn = json_decode($response);
        return $rtn->access_token;
    }
}

$rtn = (new Sample($base64_image))->run();
print_r($rtn);