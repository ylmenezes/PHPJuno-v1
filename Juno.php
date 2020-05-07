<?php

/**
 * Biblioteca de integração juno com codeiginter 3
 * Versão API Juno V1
 * @author Yan Menezes
 * @since 2020-04-28
 * @version 1.0.0
 * 
 * 
 * #################################### Construct Class ####################################
 * Você deve informar um array com os seguintes parãmentros para inicializar a class
 * 
 * $token -> Parâmetro Obirgatório 
 * $sandbox Definido por padrão como false [ False = Produção ou true = Teste] 
 * $notificationUrl -> Parâmetro Obrigatório
 * $notifyPayer -> Pardrão False [ Parâmetro para ativar/desativar notificação do plugin por email ao cliente ]
 * 
 * #########################################################################################
 */


class Juno {

    public $description;
    public $amount;
    public $dueDate;
    public $payerName;
    public $payerCpfCnpj;
    
    public $fine = 0;
    public $interest = 0;
    public $notifyPayer = false;
    public $notificationUrl = null;
    
    public $type = "XML";

    private $token = null;
    private $sandbox = false;

    const PROD_URL = "https://www.boletobancario.com/boletofacil/integration/api/v1/";
    const SANDBOX_URL = "https://sandbox.boletobancario.com/boletofacil/integration/api/v1/";

    function __construct($params = null)
    {
            try{

                if($params == null)
                    throw new Exception("Nenhum parâmetro foi inicializado para a biblioteca!");
                            
                $this->token            = $params['token']           ?: $this->token;
                $this->sandbox          = $params['sandbox']         ?: $this->sandbox;
                $this->notificationUrl  = $params['notificationUrl'] ?: $this->notificationUrl;
                $this->notifyPayer      = $params['notifyPayer']     ?: $this->notifyPayer;

            }catch(Exception $e){
                log_message('error','Error: '.$e->getMessage().' '.$e->getFile().' '.$e->getLine());
                show_error($e->getMessage());
                die();
            }
        
    }

    public function createCharge() {
             
        return $this->request('issue-charge', array(
            'token'           =>  $this->token,
            'description'     =>  $this->description,
            'amount'          =>  $this->amount,
            'dueDate'         =>  $this->dueDate,
            'fine'            =>  $this->fine,
            'interest'        =>  $this->interest,
            'payerName'       =>  $this->payerName,
            'payerCpfCnpj'    =>  $this->payerCpfCnpj,
            'notifyPayer'     =>  $this->notifyPayer,
            'notificationUrl' =>  $this->notificationUrl,
            'responseType'    =>  $this->type
        ));
    }


    /**
     * Function para cancelar cobrança pelo código
     * @since 2020-04-29
     * @author Yan Menezes
     * @param $code -> código de cobrança no gateway
     */
    public function cancelCharge($code) {
        return $this->request("cancel-charge", array(
            'token'         => $this->token,
            'code'          => $code,
            'responseType'  => $this->type
        ));
    }

     /**
     * Function para cancelar cobrança pelo código
     * @since 2020-04-30
     * @author Yan Menezes
     * @param $paymentToken -> código de cobrança no gateway
     */
    public function fetchPaymentDetails($paymentToken) {

        return $this->request("fetch-payment-details", array(
            'paymentToken'   => $paymentToken,
            'responseType'   => $this->type
        ));
    }

    private function request($urlSufix, $data) {

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL             => ($this->sandbox ? Juno::SANDBOX_URL : Juno::PROD_URL).$urlSufix,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => "UTF-8",
            CURLOPT_MAXREDIRS       => 2,
            CURLOPT_TIMEOUT         => 30,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => "POST",
            CURLOPT_POSTFIELDS      => http_build_query($data) . "\n",
            CURLOPT_HTTPHEADER      => $data
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

}