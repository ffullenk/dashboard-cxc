<?php

require_once 'application/third_party/twitteroauth/twitteroauth.php';

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
            $usuario->twitter_screen_name=$token_credentials['screen_name'];
            $usuario->save();
            
            //Logueamos al usuario
            $CI->session->set_userdata('usuario_id', $usuario->id);
            self::$user = $usuario;
            
        }
        
        redirect();
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