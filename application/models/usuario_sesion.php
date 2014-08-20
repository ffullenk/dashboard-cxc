<?php

class UsuarioSesion {

    private static $user;

    private function __construct() {
        
    }

    public static function usuario() {

        if (!isset(self::$user)) {

            $CI = & get_instance();

            if (!$user_id = $CI->session->userdata('usuario_id')) {
                return FALSE;
            }

            if (!$u = Doctrine::getTable('Usuario')->find($user_id)) {
                return FALSE;
            }

            self::$user = $u;
        }

        return self::$user;
    }

/*

    public static function login($usuario) {
        $CI = & get_instance();

        $autorizacion = self::validar_acceso($usuario, $password);

        if ($autorizacion) {
            $u = Doctrine::getTable('Usuario')->findOneByUsuarioAndOpenId($usuario, 0);

            //Logueamos al usuario
            $CI->session->set_userdata('usuario_id', $u->id);
            self::$user = $u;

            return TRUE;
        }

        return FALSE;
    }

*/

    public static function login_oauth($response_url) {
        $CI = & get_instance();
        $connection = new TwitterOAuth($CI->config->item('twitter_consumer_key'), $CI->config->item('twitter_consumer_secret'));
        $temporary_credentials = $connection->getRequestToken($response_url);
        $CI->session->set_userdata('oauth_token', $temporary_credentials['oauth_token']);
        $CI->session->set_userdata('oauth_token_secret', $temporary_credentials['oauth_token_secret']);
        $redirect_url = $connection->getAuthorizeURL($temporary_credentials);
        redirect($redirect_url);
    }

    public static function login_oauth_response() {
        $CI = & get_instance();
        $connection = new TwitterOAuth($CI->config->item('twitter_consumer_key'), $CI->config->item('twitter_consumer_secret'), $CI->session->userdata('oauth_token'), $CI->session->userdata('oauth_token_secret'));

        $token_credentials = $connection->getAccessToken($_REQUEST['oauth_verifier']);

        if (isset($token_credentials['user_id'])) {
            $usuario=Doctrine::getTable('Usuario')->findOneByTwitterId($token_credentials['user_id']);
            if(!$usuario){
                $usuario=new Usuario();
                $usuario->twitter_id=$token_credentials['user_id'];
            }
            $usuario->screen_name=$token_credentials['screen_name'];
            $usuario->save();
            
            //Logueamos al usuario
            $CI->session->set_userdata('usuario_id', $usuario->id);
            self::$user = $usuario;
            
        }
        
        redirect();
    }

    public static function login_oauth2($response_url){
        $CI = & get_instance();

        $provider = new League\OAuth2\Client\Provider\Facebook(array(
            'clientId'  =>  $CI->config->item('facebook_consumer_key'),
            'clientSecret'  =>  $CI->config->item('facebook_consumer_secret'),
            'redirectUri'   =>  $response_url
        ));

        header('Location: '.$provider->getAuthorizationUrl());
    }

    public static function login_oauth2_response() {
        $CI = & get_instance();

        $provider = new League\OAuth2\Client\Provider\Facebook(array(
            'clientId'  =>  $CI->config->item('facebook_consumer_key'),
            'clientSecret'  =>  $CI->config->item('facebook_consumer_secret'),
            'redirectUri'   =>  current_url()
        ));

        $token = $provider->getAccessToken('authorization_code', array(
            'code' => $_GET['code']
        ));

        try {

            // We got an access token, let's now get the user's details
            $token_credentials = $provider->getUserDetails($token);

            $usuario=Doctrine::getTable('Usuario')->findOneByFacebookId($token_credentials->uid);
            if(!$usuario){
                $usuario=new Usuario();
                $usuario->facebook_id=$token_credentials->uid;
            }
            $usuario->screen_name=$token_credentials->name;
            $usuario->save();

            //Logueamos al usuario
            $CI->session->set_userdata('usuario_id', $usuario->id);
            self::$user = $usuario;

            redirect();

        } catch (Exception $e) {

            // Failed to get user details
            print_r($e);
            exit('Fallo en autenticacion.');
        }

    }

    public static function logout() {
        $CI = & get_instance();
        self::$user = NULL;
        $CI->session->unset_userdata('usuario_id');
        
        redirect();
    }

    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

}

?>