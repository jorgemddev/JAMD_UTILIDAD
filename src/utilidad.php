<?php

namespace Jorgemddev\JamdUtilidad;

/**
 * Utility class with various methods common to working with strings and dates, among other things

 * (c) Jorge Morales  <jorge.md.app@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Utilidad
{

    private static $keyEncrypt = "aquí va tu key secreta";




    static function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        // $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow)); 

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public static function formatUriFriendly($string, $separator = '-')
    {
        $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|Grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $special_cases = array('&' => 'and', "'" => '');
        $string = mb_strtolower(trim($string), 'UTF-8');
        $string = str_replace(array_keys($special_cases), array_values($special_cases), $string);
        $string = preg_replace($accents_regex, '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));
        $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
        $string = preg_replace("/[$separator]+/u", "$separator", $string);
        return $string;
    }

    public static function formatNumber($number)
    {
        return number_format($number, 0, ",", ".");
    }




    public static function strFirtUppercase($str)
    {
        $result = "";
        foreach (explode(" ", $str) as $word) {
            $result .= " " . ucfirst(strtolower($word));
        }
        return $result;
    }


    public static function removeAccents($cadena)
    {
        //Reemplazamos la E y e
        $cadena = str_replace(
            array('´', "'", 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
            array('', '', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
            $cadena
        );
        //Reemplazamos la A y a
        $cadena = str_replace(
            array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
            array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
            $cadena
        );

        //Reemplazamos la E y e
        $cadena = str_replace(
            array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
            array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
            $cadena
        );

        //Reemplazamos la I y i
        $cadena = str_replace(
            array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
            array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
            $cadena
        );

        //Reemplazamos la O y o
        $cadena = str_replace(
            array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
            array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
            $cadena
        );

        //Reemplazamos la U y u
        $cadena = str_replace(
            array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
            array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
            $cadena
        );

        //Reemplazamos la N, n, C y c
        $cadena = str_replace(
            array('Ñ', 'ñ', 'Ç', 'ç'),
            array('N', 'n', 'C', 'c'),
            $cadena
        );

        return $cadena;
    }

    public static function generatePass($longitud)
    {
        $cadena = "[^A-Z0-9]";
        return substr(preg_replace($cadena, "", md5(rand())) .
            preg_replace($cadena, "", md5(rand())) .
            preg_replace($cadena, "", md5(rand())), 0, $longitud);
    }


    public static function getHumanTime($fecha_unix)
    {
        //obtener la hora en formato unix
        $ahora = time();

        //obtener la diferencia de segundos
        $segundos = $ahora - $fecha_unix;

        //dias es la division de n segs entre 86400 segundos que representa un dia;
        $dias = floor($segundos / 86400);

        //mod_hora es el sobrante, en horas, de la division de días;    
        $mod_hora = $segundos % 86400;

        //hora es la division entre el sobrante de horas y 3600 segundos que representa una hora;
        $horas = floor($mod_hora / 3600);

        //mod_minuto es el sobrante, en minutos, de la division de horas;       
        $mod_minuto = $mod_hora % 3600;

        //minuto es la division entre el sobrante y 60 segundos que representa un minuto;
        $minutos = floor($mod_minuto / 60);

        if ($horas <= 0) {
            return $minutos . " mins";
        } elseif ($dias <= 0) {
            return $horas . " hrs " . $minutos . " mins";
        } else {
            return $dias . " dias ";
        }
    }

    /**
     * Verifica si dos campos son iguales
     * @param type $field1 campo 1
     * @param type $field2 campo 2
     * @param type $message_false mensaje en caso de ser distintos
     * return boolean true si son iguales, false de lo contario
     */
    public static function validSimilary($field1, $field2, $message_false = false)
    {
        if ($field1 != $field2) {
            if ($message_false != false) {
                return $message_false;
            } else {
                return "El valor " . $field1 . " es distinto a " . $field2;
            }
            return false;
        } else {
            return true;
        }
    }

    /**
     * Valida que una url de facebook, sea valida
     * @param type $facebook
     * @return boolean
     */
    public static function idValidUrlFacebook($facebook)
    {
        if (!preg_match('/^(http\:\/\/|https\:\/\/)facebook\.com\/(?:#!\/)?(?:pages\/)?(?:[\w\-\.]*\/)*([\w\-\.]*)+$/', $facebook)) {
            return false;
        }
        return true;
    }

    /**
     * Valida que una url sea valida
     * @param type $val
     * @return boolean
     */
    public static function isValidUrl($val)
    {
        if (!filter_var($val, FILTER_VALIDATE_URL)) {
            return false;
        }
        return true;
    }

    /**
     * devuelve el mes en español
     * @param int $mes mes correspondiente del 1 al 12
     * @return string retorna mes en español
     */
    public static function getMonthSpanish($mes = 0)
    {
        $meses = array('', 'enero', 'ferebro', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
        if ($mes > 0) {
            return $meses[$mes];
        } else {
            $mes_actual = date('n');
            return $meses[$mes_actual];
        }
    }

    /**
     * devuelve el dia en español, segun su numero
     * @param int $day dia del  1 al 7
     * @return string retorna mes en español
     */
    public static function getDays($day = 0)
    {
        $days = array('domingo', 'lunes', 'martes', 'miercoles', 'jueves', 'sabado', 'domingo');
        return $days[$day];
    }

    /**
     * Valida que una cadena sea un mail
     * @param string $email
     * @return bool
     */
    public static function isValidEmail($email)
    {
        $matches = null;
        return (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $email, $matches));
    }

    /**
     * Valida si un texto es valido, escapa caracteres especiales
     * @param String $str
     * @return boolean true si es validado, false de lo contrario
     */
    public static function isValidString($str)
    {
        if (isset($str)) {
            $t1 = rtrim($str);
            $t2 = ltrim($t1);
            $t3 = trim($t2);
            $texto = htmlentities($t3);
            return preg_match('^/[a-zA-Z]/', $texto);
        } else {
            return FALSE;
        }
    }



    /**
     * Compara fechas
     */
    public static function compareDate($date1, $date2)
    {
        $fecha1 = strtotime($date1);
        $fecha2 = strtotime($date2);
        if ($fecha1 == $fecha2) {
            return '1=2';
        } else {
            if ($fecha1 > $fecha2) {
                return '1>2';
            } else {
                return '1<2';
            }
        }
    }


    /**
     * Funcion para validar una hora en formato:
     *  hh:mm
     * Devuelve true|false
     */
    public static function isValidTime($time)
    {
        $pattern = "/^([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])$/";
        if (preg_match($pattern, $time))
            return true;
        return false;
    }

    /**
     * Valida que sea un rut valido, CHILE
     */
    public static function isValidRut($rut = 0)
    {
        if (isset($rut) && strlen($rut) > 5) {
            $rut = preg_replace('/[^k0-9]/i', '', $rut);
            $dv = substr($rut, -1);
            $numero = substr($rut, 0, strlen($rut) - 1);
            $i = 2;
            $suma = 0;
            foreach (array_reverse(str_split($numero)) as $v) {
                if ($i == 8)
                    $i = 2;
                $suma += $v * $i;
                ++$i;
            }
            $dvr = 11 - ($suma % 11);
            if ($dvr == 11)
                $dvr = 0;
            if ($dvr == 10)
                $dvr = 'K';
            if ($dvr == strtoupper($dv))
                return true;
            else
                return false;
        } else {
            return FALSE;
        }
    }

    /**
     * Valida que el captcha V2, sea valido
     */
    public static function validateReCaptchaV2($captcha,$key_secret) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $key_secret, 'response' => $captcha)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $arrResponse = json_decode($response, true);
        if ($arrResponse["success"] == true) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * da formato a una fecha
     */
    public static function formatDate($date, $format = "d-m-Y")
    {
        return date($format, strtotime($date));
    }

    /**
     * Da formato  un rut sin puntos ni guion y lo formatea a 11.000.000-0 Chile
     * @param type $rut
     * @return type
     */
    public static function formatRut($rut = 0)
    {
        $pr = str_replace(".", "", $rut);
        $pr = str_replace("-", "", $rut);
        $lan1 = strlen($pr);
        $dig = substr($pr, strlen($pr) - 1, 1);
        $indb1 = $lan1 - 1;
        $bq1 = substr($pr, 0, $indb1);

        $lan2 = strlen($bq1);

        $bq2 = substr($bq1, 0, $lan2 - 3);
        $lan3 = strlen($bq2);
        $b1 = "";
        if ($lan1 == 9) {
            $b1 = substr($bq2, 0, 2);
        }
        if ($lan1 == 8) {
            $b1 = substr($bq2, 0, 1);
        }
        $b2 = substr($bq2, $lan3 - 3);
        $b3 = substr($bq1, $lan2 - 3);

        return $b1 . "." . $b2 . "." . $b3 . "-" . $dig;
    }

    /**
     * Count days
     * @param type $date1 initial
     * @param type $date2 finish
     * @return number
     */
    public static function countDays($date1, $date2, $abs = false)
    {
        $dias = (strtotime($date2) - strtotime($date1)) / 86400;
        //$dias = abs($dias);
        $dias = floor($dias);
        if ($abs) {
            return abs($dias) + 1;
        } else {
            return $dias + 1;
        }
    }

    /**
     * Cuenta minutos entre dos fechas
     */
    public static function countMinutes($date1, $date2)
    {
        $minutos = (strtotime($date1) - strtotime($date2)) / 60;
        $minutos = abs($minutos);
        $minutos = floor($minutos);
        return $minutos;
    }




    /**
     * crea una sentencia sql para concatenar desde una array clave: valor
     */
    public static function prepareQuerySql($array, $exclude = array())
    {
        $sql = "";
        $i = 0;
        if ($array) {
            foreach ($array as $key => $value) {
                if (!in_array($key, $exclude)) {
                    $sql .= " and " . $key . "=" . "'$value'";
                }
            }
            return $sql;
        } else {
            return false;
        }
    }



    /**
     * calcula la diferencia en minutos entre dos fechas
     */
    public static function differenceMinutes($date1, $date2 = Null)
    {
        $time1 = strtotime($date1);
        if ($date2 != null) {
            $time2 = strtotime($date2);
        } else {
            $time2 = time();
        }
        $result = $time2 - $time1;
        return $result / 60;
    }

    /**
     * convierte una fecha a minutos
     */
    public static function convertDateToMinutes($tiempo_en_segundos)
    {
        $horas = floor($tiempo_en_segundos / 3600);
        $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
        $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);

        $hora_texto = "";
        if ($horas > 0) {
            $hora_texto .= $horas . "h ";
        }

        if ($minutos > 0) {
            $hora_texto .= $minutos . "m ";
        }

        if ($segundos > 0) {
            $hora_texto .= $segundos . "s";
        }

        return $hora_texto;
    }

    /**
     * encriptar un texto
     */
    public static function encrypt($data, $ive = null)
    {
        $method = 'aes-256-cbc';
        if ($ive == null) {
            $iv = mb_strcut(base64_encode(rand(1, 999) . date("YdmHis")), 0, 16);
        } else {
            $iv = $ive;
        }
        return array("data" => openssl_encrypt($data, $method, self::$keyEncrypt, false, $iv), "iv" => $iv);
    }

    /**
     * desencriptar un texto
     */
    public static function decrypt($data, $iv)
    {
        $method = 'aes-256-cbc';
        return openssl_decrypt($data, $method, self::$keyEncrypt, false, $iv);
    }
    /**
     * Valida si una fecha es correcta
     * @param String $date
     * @return boolean true, success
     */
    public static function validateDate($date, $format = 'd-m-Y') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * convierte una fecha a palabras en español
     */
    public static function getDateLetters($fecha)
    {
        $dia = Utilidad::meetDayWeek($fecha);
        $num = date("j", strtotime($fecha));
        $anno = date("Y", strtotime($fecha));
        $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
        $mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
        return $dia . ', ' . $num . ' de ' . $mes . ' del ' . $anno;
    }

    /**
     * Devuelve el dia de la semana
     */
    public static function meetDayWeek($fecha)
    {
        $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
        $dia = $dias[date('w', strtotime($fecha))];
        return $dia;
    }
}
