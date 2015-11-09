<?php
date_default_timezone_set('America/New_York');

/**
 * TODO
 *
 * - Get site name from WP
 * - Build some kind of email builder
 * - Build some kind of validation system which will make an K->V array of Label / Message for email
 *
 **/
class form_builder {
    public $request;
    public $post;
    public $strings;
    public $tables;
    public $errorVals;
    public $placeholder;
    public $errors;
    public $lang;
    public $proceed;
    public $staticVars;
    public $date;
    public $userEntered;
    public $sendTo;
    public $sendNewsletterTo;
    public $sendFromAddr;
    public $sendFromName;
    public $emailSubject;




    public function __construct($lang,array $errorVals, array $placeholder, array $emailSetting) {
        ///* @var wpdb $wpdb */
        //$this->wpdb = $wpdb;
        //$this->wpdb->show_errors();
        //$this->wpdb->hide_errors();
        $this->lang             = $lang;
        $this->userEntered      = array(
            'entered' => false,
            'message' => ''
        );
        $this->proceed          = true;
        $this->date             = date("Y-m-d H:i:s");
        $this->request          = (isset($_REQUEST) ? $_REQUEST : false);
        $this->post             = (isset($_POST) ? $_POST : false);
        // $this->sendNewsletterTo = "newsletter@presentex.com";
        $this->sendTo           = $emailSetting['sendTo'];

        $this->sendFromAddr = $this->sendTo; //"eric.bright@designshopp.com";
        //$this->sendFromAddr     = "eric.bright@designshopp.com";
        $this->sendFromName = $emailSetting['sendFromName'];
        $this->errorVals = $errorVals;
        $this->placeholder = $placeholder;
        $this->emailSubject = $emailSetting['emailSubject'];
        $this->recaptcha    = array(
            'secret_key' => '6Lcvbg4TAAAAADZi4zjWvmDY5UKl-7lCQ_YDJMBJ',
            'site_key'   => '6Lcvbg4TAAAAADq8-EXiMbYFx_e67pazOaRV8v5Z',
        );
    }

    /**
     * See WordPress' Docs
     *
     * @param $value
     * @return array|string
     */
    private function stripslashes_deep($value) {
        if (is_array($value)) {
            $value = array_map('stripslashes_deep', $value);
        } elseif (is_object($value)) {
            $vars = get_object_vars($value);
            foreach ($vars as $key => $data) {
                $value->{$key} = $this->stripslashes_deep($data);
            }
        } elseif (is_string($value)) {
            $value = stripslashes($value);
        }

        return $value;
    }

    /** See WordPress' Docs**/
    private function parse_str($string, &$array) {
        parse_str($string, $array);
        if (get_magic_quotes_gpc()):
            $array = $this->stripslashes_deep($array);
        endif;
    }

    /** Merges arrays to provide a default**/
    private function parse_args($args, $defaults = '') {
        if (is_object($args))
            $r = get_object_vars($args);
        elseif (is_array($args))
            $r =& $args;
        else
            $this->parse_str($args, $r);

        if (is_array($defaults))
            return array_merge($defaults, $r);
        return $r;
    }

    private function less_one_day($date) {
        $lastEntry        = strtotime($date);
        $lastEntryPlusOne = $lastEntry + (24 * 60 * 60);
        $currentDate      = strtotime($this->date);

        return ($lastEntryPlusOne <= $currentDate);
    }


    private function different_day($date) {
        $lastEntry   = array(
            'year'  => date('Y', strtotime($date)),
            'month' => date('m', strtotime($date)),
            'day'   => date('d', strtotime($date))
        );
        $currentDate = array(
            'year'  => date('Y', strtotime($this->date)),
            'month' => date('m', strtotime($this->date)),
            'day'   => date('d', strtotime($this->date))
        );
        $lastDay     = intval($lastEntry['day']);
        $currentDay  = intval($currentDate['day']);

        return ($lastDay !== $currentDay);
    }

    private function convert($str) {
        return iconv("UTF-8", "ISO-8859-1", $str);
    }


    public function sanitize($field_name, $type = 'text') {
        $var = $this->request[$field_name];
        return trim($var);
    }

    public function has_error($field_name) {
        if (isset($this->errors[$field_name]) && $this->errors[$field_name]) {
            return true;
        } else {
            return false;
        }
    }

    public function get_error_label($field_name, $type = 'required') {
        if ($this->has_error($field_name)):
            echo "<label for='$field_name' class='error'>{$this->errorVals[$field_name][$type]}</label>";
        else:
            return false;
        endif;
    }

    public function strlen($field_name) {
        $return = 0;
        if (isset($this->request[$field_name])):
            $return = strlen($this->request[$field_name]);
        endif;
        return $return;
    }

    public function is_valid($field_name, $type = 'text') {
        $return = false;

        if ($type == 'email') {
            /** TODO: FIND A USE FOR THIS? **/
            $return = filter_var( $this->request[ $field_name ], FILTER_VALIDATE_EMAIL );
        }elseif ($type == 'tel') {
            $return = preg_match( '/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/', $this->request[ $field_name ] ) ;
        }else{
            if (isset($this->request[$field_name])) {
                if ($this->request[$field_name] !== ''
                    && $this->request[$field_name] !== 0
                    && $this->request[$field_name] !== '0'
                    && $this->request[$field_name] !== 'null'
                ) {

                    $return = true;
                }
            }
        }


        return $return;
    }
    public function getCurlData($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
        $curlData = curl_exec($curl);
        curl_close($curl);
        return $curlData;
    }
    private function create_internal_options($field_name, $extras) {
        $return = '';
        $key = key($extras['options']);
        if(($key === "country")){
            if ($extras['placeholder']) $return .= "<option selected='selected'>{$this->ip_info("Visitor", "Country")}</option><option disabled>_________</option>";

            if($extras['options']['country'] =='en')
                require_once 'country.php';

            if($extras['options']['country'] =='fr')
                require_once 'pays.php';

            foreach ($countries as $option) {
                $sanitize_option = sanitize_title($option);
                $return .= "<option value='{$sanitize_option}'>{$option}</option>";
            }
        }else{
            if ($extras['placeholder']) $return .= "<option selected='selected'>{$this->placeholder[$field_name]}</option>";
            foreach ($extras['options'] as $option) {
                $sanitize_option = sanitize_title($option);
                $return .= "<option value='{$sanitize_option}'>{$option}</option>";
            }
        }



        return $return;

    }

    private function is_type($needle, $haystack) {
        $return = false;
        if (is_array($haystack)):
            $return = in_array($needle, $haystack);
        else:
            return ($needle == $haystack);
        endif;
        return $return;
    }

    private function create_internal($field_name, $extras) {
        $return = '';
        switch ($extras['type']):
            case 'phone':
                break;
        endswitch;
        if ($extras['placeholder'] && !$this->is_type($extras['type'], 'select')) $return .= " placeholder='{$this->placeholder[$field_name]}'";
        if ($extras['class']) $return .= " class='{$extras['class']}'";

        $return .= " name='$field_name' id='{$extras['field_id']}'";

        if ($this->is_valid($field_name, $extras['type']) && $this->is_type($extras['type'], array('text', 'tel', 'email'))):
            $return .= " value='{$this->request[$field_name]}'";
        endif;

        if ($this->is_valid($field_name, $extras['type']) && ($this->is_type($extras['type'], array('checkbox', 'radio')))):
            $return .= " checked='checked'";
        endif;
        return $return;

    }

    public function get_placeholder($field_name) {
        return $this->placeholder[$field_name];
    }

    public function create($field_name, $optional = array()) {

        $defaults = array(
            'required'    => false,
            'field_id'    => false,
            'type'        => 'text',
            'placeholder' => false,
            'classes'     => false
        );

        if (!$optional['field_id']) $optional['field_id'] = $field_name . '_id';

        $extras = $this->parse_args($optional, $defaults);

        if (!$extras['field_id']) $extras['field_id'] = $field_name;
        $return = '';


        switch ($extras['type']):
            case 'textarea':
                $return .= "<textarea style='width:100%'  rows='10'" ;
                $return .= $this->create_internal($field_name, $extras);
                $return .= '>';
                if ($this->is_valid($field_name, $extras['type'])):
                    $return .= $this->request[$field_name];
                endif;
                $return .= "</textarea>";
                break;

            case 'checkbox':
            case 'radio':
                $return .= "<input";
                $return .= " type='{$extras['type']}' ";
                $return .= $this->create_internal($field_name, $extras);
                $return .= "/>";

                break;
            case 'select':
                $return .= "<select";
                $return .= $this->create_internal($field_name, $extras);
                $return .= ">";
                if (isset($extras['options'])):
                    $return .= $this->create_internal_options($field_name, $extras);
                endif;

                $return .= "</select>";

                break;

            case 'text':
                $return .= "<input";
                $return .= " type='text' ";
                $return .= $this->create_internal($field_name, $extras);
                $return .= "/>";

                break;
            case 'tel':
                $return .= "<input";
                $return .= " type='tel' ";
                $return .= $this->create_internal($field_name, $extras);
                $return .= "/>";
                break;
            case 'email':
                $return .= "<input";
                $return .= " type='email' ";
                $return .= $this->create_internal($field_name, $extras);
                $return .= "/>";
                break;
            case 'hidden':
                $return .= '<input';
                $return .= " type='hidden' ";
                $return .= $this->create_internal( $field_name, $extras );
                $return .= '/>';
                break;
            default:
                $return .= "<input";
                $return .= " type='text' ";
                $return .= $this->create_internal($field_name, $extras);
                $return .= "/>";

                break;
        endswitch;

        echo $return;
    }

    public function get_ip() {
        $return_ip = null;
        if ( $_SERVER['HTTP_X_FORWARDED_FOR'] !== null ):
            $return_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        elseif ( $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'] !== null ):
            $return_ip = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        else:
            $return_ip = $_SERVER['REMOTE_ADDR'];
        endif;

        return $return_ip;
    }

    function get_page_id($name, $lang = false){
        if(!$lang) $lang = get_lang_active();
        switch($name){
            case 'home':
                return ($lang == 'en' ? 2 : get_default_id(2, 'page', 'fr'));
                break;
            case 'architect':
                return ($lang == 'en' ? 9 : get_default_id(9, 'page', 'fr'));
            case 'exhibition':
                return ($lang == 'en' ? 11 : get_default_id(11, 'page', 'fr'));
            case 'thanks':
                return ($lang == 'en' ? 308 : get_default_id(308, 'page', 'fr'));
        }
        return false;
    }

//echo ip_info("Visitor", "Country"); // India
//echo ip_info("Visitor", "Country Code"); // IN
//echo ip_info("Visitor", "State"); // Andhra Pradesh
//echo ip_info("Visitor", "City"); // Proddatur
//echo ip_info("Visitor", "Address"); // Proddatur, Andhra Pradesh, India
//
//print_r(ip_info("Visitor", "Location")); // Array ( [city] => Proddatur [state] => Andhra Pradesh [country] => India [country_code] => IN [continent] => Asia [continent_code] => AS )
    /**
     * @param null $ip
     * @param string $purpose
     * @param bool|TRUE $deep_detect
     * @return array|null|string
     */
    private function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }
}

