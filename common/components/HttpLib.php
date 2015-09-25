<?php
namespace common\components;

class HttpLib {
    // user-agent
    const HTTPLIB_USER_AGENT = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:6.0.2) Gecko/20100101 Firefox/6.0.2';
    // begin time
    private $begin_time, $type = 'curl';

    /**
     * get
     *
     * @param string $url
     * @param array $args
     * @return array|bool|mixed|void
     * [
     *  headers => [],
     *  body => "",
     *  response
     * ]
     */
    public function get($url,$args=array()) {
        $defaults = array(
            'method'  => 'GET',
        );
        $args = array_merge($args, $defaults);
        return $this->request($url,$args);
    }
    /**
     * post
     *
     * @param string $url
     * @param array $args
     * @param array $body
     * @return array|bool|mixed|void
     */
    public function post($url, $body, $args=array()) {
        $defaults = array(
            'method'  => 'POST',
            'body'  => $body,
        );
        $args = array_merge($args, $defaults);
        return $this->request($url,$args);
    }
    /**
     * head
     *
     * @param string $url
     * @param array $args
     * @return array|bool|mixed|void
     */
    public function head($url,$args=array()) {
        $defaults = array('method' => 'HEAD');
        $args = array_merge($args, $defaults);
        return $this->request($url,$args);
    }
    /**
     * 强制使用curl
     *
     * @return void
     */
    public function use_curl() {
        $this->type = 'curl';
    }
    /**
     * 强制使用socket
     *
     * @return void
     */
    public function use_socket() {
        $this->type = 'socket';
    }
    /**
     * request
     *
     * @param string $url
     * @param array $options
     * @return array|void
     */
    public function request($url, $options = array()) {
        $this->begin_time = microtime(true);
        $defaults = array(
            'method'      => 'GET',
            'timeout'     => 30,
            'redirection' => 3,
            'user-agent'  => self::HTTPLIB_USER_AGENT,
            'blocking'    => true,
            'headers'     => array(),
            'body'        => null,
            'httpversion' => '1.1',
        );

        $r = array_merge( $defaults, $options );
        if (is_null($r['headers'])) $r['headers'] = array();

        // headers 不是数组时需要处理
        if (!is_array($r['headers'])) {
            $headers = $this->parse_header($r['headers']);
            $r['headers'] = $headers['headers'];
        }

        // 处理user-agent
        if ( isset($r['headers']['User-Agent']) ) {
            $r['user-agent'] = $r['headers']['User-Agent'];
            unset($options['headers']['User-Agent']);
        } else if( isset($r['headers']['user-agent']) ) {
            $r['user-agent'] = $r['headers']['user-agent'];
            unset($r['headers']['user-agent']);
        }

        if ( !isset($r['headers']['Accept']) && !isset($r['headers']['accept']) )
            $r['headers']['Accept'] = '*/*';

        if ( !isset($r['headers']['Accept-Language']) && !isset($r['headers']['accept-language']) && isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) )
            $r['headers']['Accept-Language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

        if ( !isset($r['headers']['Accept-Charset']) && !isset($r['headers']['accept-charset']) )
            $r['headers']['Accept-Charset'] = empty($_SERVER['HTTP_ACCEPT_CHARSET']) ? 'utf-8' : $_SERVER['HTTP_ACCEPT_CHARSET'];


        // Construct Cookie: header if any cookies are set
        $this->build_cookie_header( $r );

        // 判断是否支持gzip
        if (function_exists('gzuncompress') || function_exists('gzdeflate') || function_exists('gzinflate'))
            $r['headers']['Accept-Encoding'] = $this->accept_encoding();

        // 判断数据处理类型
        if (empty($r['body'])) {
            if(($r['method'] == 'POST') && !isset($r['headers']['Content-Length'])) {
                $r['headers']['Content-Length'] = 0;
            }
        } else {
            if (is_array($r['body'])) {
                $r['body'] = http_build_query($r['body'],null,'&');
                $r['headers']['Content-Type'] = 'application/x-www-form-urlencoded';
                $r['headers']['Content-Length'] = strlen($r['body']);
            }
            if (!isset($r['headers']['Content-Length']) && !isset($r['headers']['content-length'])) {
                $r['headers']['Content-Length'] = strlen($r['body']);
            }
        }

        $response = array();
        // force curl
        if ($this->type == 'curl' && function_exists('curl_init') && function_exists('curl_exec')) {
            $response = $this->cURL($url, $r);
        }
        // force fsockopen
        elseif ($this->type == 'socket' && function_exists('fsockopen')) {
            $response = $this->fsockopen($url, $r);
        }
        // cUrl
        elseif (function_exists('curl_init') && function_exists('curl_exec')) {
            $response = $this->cURL($url, $r);
        }
        // fsockopen
        elseif(function_exists('fsockopen')) {
            $response = $this->fsockopen($url, $r);
        }
        return $response;
    }
    // 代理host port
    private $proxy_host, $proxy_port;
    /**
     * 设置代理信息
     *
     * @param string $host
     * @param string $port
     * @return bool
     */
    public function set_proxy($host, $port) {
        $result = array($this->proxy_host, $this->proxy_port);
        $this->proxy_host = $host;
        $this->proxy_port = $port;
        return $result;
    }
    /**
     * curl 发送之前的处理
     *
     * @param resource $handle
     * @param string $header
     * @return int
     */
    public function curl_before_send($handle, $header) {
        if (preg_match("/Location\:(.+)\r\n/i", $header)) {
            curl_setopt( $handle, CURLOPT_POST, false );
            curl_setopt( $handle, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
        }
        return strlen($header);
    }
    /**
     * curl
     *
     * @param string $url
     * @param array $r
     * @return array|void
     */
    public function cURL($url, $r) {
        // 解析url
        $aurl = $this->parse_url($url);
        $handle = curl_init();

        // 代理
        if ($this->proxy_host && $this->proxy_port) {
            if ( version_compare(PHP_VERSION, '5.0.0', '>=') ) {
                curl_setopt( $handle, CURLOPT_PROXYTYPE, CURLPROXY_HTTP );
                curl_setopt( $handle, CURLOPT_PROXY, $this->proxy_host );
                curl_setopt( $handle, CURLOPT_PROXYPORT, $this->proxy_port );
            } else {
                curl_setopt( $handle, CURLOPT_PROXY, $this->proxy_host .':'. $this->proxy_port );
            }
        }


        // CURLOPT_TIMEOUT and CURLOPT_CONNECTTIMEOUT expect integers.  Have to use ceil since
        // a value of 0 will allow an ulimited timeout.
        $timeout = (int) ceil( $r['timeout'] );
        curl_setopt( $handle, CURLOPT_CONNECTTIMEOUT, $timeout );
        curl_setopt( $handle, CURLOPT_TIMEOUT, $timeout );

        curl_setopt( $handle, CURLINFO_HEADER_OUT, true );
        curl_setopt( $handle, CURLOPT_HEADERFUNCTION, array(&$this,'curl_before_send') );

        curl_setopt( $handle, CURLOPT_URL, $url);
        curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $handle, CURLOPT_USERAGENT, $r['user-agent'] );
        curl_setopt($handle, CURLOPT_REFERER, "http://xue.youdao.com");   //来路
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:220.181.76.239', 'CLIENT-IP:220.181.76.239'));//ip
        if ($r['redirection'] > 0)
            curl_setopt($handle, CURLOPT_MAXREDIRS, $r['redirection']);

        if (!isset($r['headers']['referer']) && !isset($r['headers']['Referer'])) {
            curl_setopt( $handle, CURLOPT_REFERER, $aurl['referer'] );
        }

        switch ( $r['method'] ) {
            case 'HEAD':
                curl_setopt( $handle, CURLOPT_NOBODY, true );
                break;
            case 'POST':
                curl_setopt( $handle, CURLOPT_POST, true );
                curl_setopt( $handle, CURLOPT_POSTFIELDS, $r['body'] );
                break;
        }

        if ( true === $r['blocking'] )
            curl_setopt( $handle, CURLOPT_HEADER, true );
        else
            curl_setopt( $handle, CURLOPT_HEADER, false );

        // The option doesn't work with safe mode or when open_basedir is set.
        // Disable HEAD when making HEAD requests.
        if ( $r['redirection'] > 0 && !ini_get('safe_mode') && !ini_get('open_basedir') && 'HEAD' != $r['method'] )
            curl_setopt( $handle, CURLOPT_FOLLOWLOCATION, true );

        if ( !empty( $r['headers'] ) ) {
            // cURL expects full header strings in each element
            $headers = array();
            foreach ( $r['headers'] as $name => $value ) {
                $headers[] = "{$name}: $value";
            }
            curl_setopt( $handle, CURLOPT_HTTPHEADER, $headers );
        }

        if ( $r['httpversion'] == '1.0' )
            curl_setopt( $handle, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0 );
        else
            curl_setopt( $handle, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );

        // 提交
        $str_response = curl_exec( $handle );


        // We don't need to return the body, so don't. Just execute request and return.
        if ( ! $r['blocking'] ) {
            curl_close( $handle );
            return array('headers' => array(), 'body' => '', 'response' => array('code' => false, 'message' => false), 'cookies' => array());
        }

        // 重置计时器
        $this->begin_time = microtime(true);
        // 获取数据
        if ( !empty($str_response) ) {
            $length = curl_getinfo($handle, CURLINFO_HEADER_SIZE);
            $headers = trim( substr($str_response, 0, $length) );
            if ( strlen($str_response) > $length )
                $the_body = substr( $str_response, $length );
            else
                $the_body = '';

            if ( false !== strrpos($headers, "\r\n\r\n") ) {
                $header_parts = explode("\r\n\r\n", $headers);
                $headers = $header_parts[ count($header_parts) -1 ];
            }
            // 记录日志

            $headers = $this->parse_header($headers);
        } else {
            if ( $curl_error = curl_error($handle) )
                upf_error($curl_error);
            if ( in_array( curl_getinfo( $handle, CURLINFO_HTTP_CODE ), array(301, 302) ) )
                upf_error(__('过多的重定向。'));

            $headers = array( 'headers' => array(), 'cookies' => array() );
            $the_body = '';
        }
        $response = array();
        $response['code']    = curl_getinfo( $handle, CURLINFO_HTTP_CODE );
        $response['message'] = self::status_desc($response['code']);

        curl_close( $handle );

        // When running under safe mode, redirection is disabled above. Handle it manually.
        if ( !empty($headers['headers']['location']) && $r['redirection']>0 && (ini_get('safe_mode') || ini_get('open_basedir')) ) {
            if ( $r['redirection']-- > 0 ) {
                return $this->request($this->get_redirection_url($aurl, $headers['headers']['location']), $r);
            } else {
                upf_error(__('过多的重定向。'));
            }
        }
        if (isset($headers['headers']['location'])) {
            $headers['headers']['location'] = $this->get_redirection_url($aurl, $headers['headers']['location']);
        }
        if ( true === $this->should_decode($headers['headers']) ) {
            $error_level = error_reporting(0);
            $the_body    = $this->decompress( $the_body );
            error_reporting($error_level);
        }
        // 自动编码转换
        $get_charset = null;
        if (preg_match("/<meta\s*http\-equiv[^>]*?content\s*=\s*[\"']?[\w\/]+;\s*charset\s*=\s*([^\"']+)[\"']?\s*\/?>/i", $the_body, $match)) {
            $get_charset = trim($match[1]);
            $the_body = str_replace($match[0], str_replace($match[1], 'utf-8', $match[0]), $the_body);
        }
        elseif (preg_match('/charset=(.+)$/i', $headers['headers']['content-type'], $match)) {
            $get_charset = trim($match[1]);
        }
        if ($get_charset && strtolower($get_charset) != 'utf-8') {
            $the_body = iconvs($get_charset, 'utf-8', $the_body);
        }

        return array(
            'headers'   => $headers['headers'],
            'body'      => $the_body,
            'response'  => $response,
            'cookies'   => $headers['cookies'],
        );
    }

    private $sock_hosts = null;
    /**
     * fsockopen
     *
     * @param string $url
     * @param array $r
     * @return array|void
     */
    public function fsockopen($url, $r) {
        // 解析url
        $aurl = $this->parse_url($url);
        $host = $aurl['host'];
        if ('localhost' == strtolower($host)) $host = '127.0.0.1';
        // 安全请求
        if ($aurl['scheme'] == 'https' && extension_loaded('openssl')) {
            $host = 'ssl://'.$host; $aurl['port'] = 443;
        }
        // 连接服务器
        $start_delay = time();
        $error_level = error_reporting(0);
        // DNS缓存
        if (!isset($this->sock_hosts[$host]) && !preg_match('/^(?:\d{1,3}\.){3}(?:\d{1,3})$/', $host)) {
            $this->sock_hosts[$host] = $host = gethostbyname($host);
        } elseif(isset($this->sock_hosts[$host])) {
            $host = $this->sock_hosts[$host];
        }
        // 代理
        if ($this->proxy_host && $this->proxy_port) {
            $handle = fsockopen($this->proxy_host, $this->proxy_port, $errno, $errstr, $r['timeout']);
        } else {
            $handle = fsockopen($host, $aurl['port'], $errno, $errstr, $r['timeout']);
        }
        $end_delay = time();
        error_reporting($error_level);

        // 连接错误
        if (false === $handle) upf_error(sprintf('%s: %s', $errno, $errstr));
        // 连接时间超过超时时间，暂时禁用当前方法
        $elapse_delay = ($end_delay - $start_delay) > $r['timeout'];
        if (true === $elapse_delay) {
            // TODO 连接超时
        }
        // 设置超时时间
        stream_set_timeout($handle, $r['timeout']);

        if ($this->proxy_host && $this->proxy_port) {
            $request_path = $url;
        } else {
            $request_path = $aurl['path'].$aurl['query'];
        }

        // 拼装headers
        if (empty($request_path)) $request_path = '/';
        $str_headers = sprintf("%s %s HTTP/%s\r\n",strtoupper($r['method']), $request_path, $r['httpversion']);
        if ($this->proxy_host && $this->proxy_port) {
            $str_headers.= sprintf("Host: %s:%s\r\n",$aurl['host'], $aurl['port']);
        } else {
            $str_headers.= sprintf("Host: %s\r\n", $aurl['host']);
        }
        // user-agent
        if (isset($r['user-agent']))
            $str_headers.= sprintf("User-Agent: %s\r\n",$r['user-agent']);
        // 其他字段
        if (is_array($r['headers'])) {
            foreach ( (array) $r['headers'] as $header => $headerValue )
                $str_headers.= sprintf("%s: %s\r\n",$header,$headerValue);
        } else {
            $str_headers.= $r['headers'];
        }
        // referer
        if (!isset($r['headers']['referer']) && !isset($r['headers']['Referer']))
            $str_headers.= sprintf("Referer: %s\r\n",$aurl['referer']);

        // connection
        if (!isset($r['headers']['connection']))
            $str_headers.= "Connection: close\r\n";

        $str_headers.= "\r\n";

        if (!is_null($r['body'])) $str_headers.= $r['body'];

        // 提交
        fwrite($handle, $str_headers);

        // 记录日志

        // 非阻塞模式
        if (!$r['blocking']) {
            fclose($handle);
            return array('headers' => array(), 'body' => '', 'response' => array('code' => false, 'message' => false), 'cookies' => array());
        }
        // 重置计时器
        $this->begin_time = microtime(true);
        // 读取服务器返回数据
        $str_response = '';
        while (!feof($handle)) {
            $str_response .= fread($handle, 4096);
        }

        fclose($handle);



        // 处理服务器返回的结果
        $response = explode("\r\n\r\n", $str_response, 2);
        $process  = array('headers' => isset($response[0]) ? $response[0] : array(), 'body' => isset($response[1]) ? $response[1] : '');

        // 记录日志
        // 处理headers
        $headers = $this->parse_header($process['headers']);

        // 响应代码是400范围内？
        if ((int)$headers['response']['code'] >= 400 && (int)$headers['response']['code'] < 500)
            upf_error($headers['response']['code'].': '.$headers['response']['message']);

        // 重定向到新的位置
        if ('HEAD' != $r['method'] && $r['redirection']>0 && isset($headers['headers']['location'])) {
            if ($r['redirection']-- > 0) {
                $r['method'] = 'GET'; $r['headers']['Referer'] = $url; $r['cookies'] = $headers['cookies'];
                unset($r['body'], $r['headers']['Content-Type'], $r['headers']['Content-Length']);
                return $this->request($this->get_redirection_url($aurl, $headers['headers']['location']), $r);
            } else {
                upf_error(__('过多的重定向。'));
            }
        }
        if (isset($headers['headers']['location'])) {
            $headers['headers']['location'] = $this->get_redirection_url($aurl, $headers['headers']['location']);
        }


        // If the body was chunk encoded, then decode it.
        if (!empty($process['body']) && isset($headers['headers']['transfer-encoding']) && 'chunked' == $headers['headers']['transfer-encoding'])
            $process['body'] = self::decode_chunked($process['body']);

        if ( true === $this->should_decode($headers['headers']) ) {
            $error_level     = error_reporting(0);
            $process['body'] = $this->decompress( $process['body'] );
            error_reporting($error_level);
        }

        // 自动编码转换
        $get_charset = null;
        if (preg_match("/<meta\s*http\-equiv[^>]*?content\s*=\s*[\"']?[\w\/]+;\s*charset\s*=\s*([^\"']+)[\"']?\s*\/?>/i", $process['body'], $match)) {
            $get_charset = trim($match[1]);
            $process['body'] = str_replace($match[0], str_replace($match[1], 'utf-8', $match[0]), $process['body']);
        }
        elseif (preg_match('/charset=(.+)$/i', $headers['headers']['content-type'], $match)) {
            $get_charset = trim($match[1]);
        }
        if ($get_charset && strtolower($get_charset) != 'utf-8') {
            $process['body'] = iconvs($get_charset, 'utf-8', $process['body']);
        }
        return array(
            'headers'   => $headers['headers'],
            'body'      => $process['body'],
            'response'  => $headers['response'],
            'cookies'   => $headers['cookies'],
        );
    }
    /**
     * 创建 cookie header
     *
     * @param $r
     * @return void
     */
    private function build_cookie_header( &$r ) {
        if ( ! empty($r['cookies']) ) {
            $cookies_header = '';
            foreach ( (array) $r['cookies'] as $cookie ) {
                if (!empty($cookie['name']) && !empty($cookie['value'])) {
                    $cookies_header .= $cookie['name'] . '=' . urlencode( $cookie['value'] ) . '; ';
                }
            }
            $cookies_header = substr( $cookies_header, 0, -2 );
            $r['headers']['cookie'] = $cookies_header;
        }
    }
    /**
     * What encoding types to accept and their priority values.
     *
     * @return string Types of encoding to accept.
     */
    private function accept_encoding() {
        $type = array();
        if (function_exists('gzinflate'))
            $type[] = 'deflate;q=1.0';

        if (function_exists('gzuncompress'))
            $type[] = 'compress;q=0.5';

        if (function_exists('gzdecode'))
            $type[] = 'gzip;q=0.5';

        return implode(', ', $type);
    }
    /**
     * 判断是否需要解码
     *
     * @param array|string $headers
     * @return bool
     */
    private function should_decode($headers) {
        if ( is_array( $headers ) ) {
            if ( array_key_exists('content-encoding', $headers) && ! empty( $headers['content-encoding'] ) )
                return true;
        } else if ( is_string( $headers ) ) {
            return ( stripos($headers, 'content-encoding:') !== false );
        }

        return false;
    }
    /**
     * 格式化url
     *
     * @param array $aurl
     * @param string $location
     * @return string
     */
    private function get_redirection_url($aurl, $location) {
        $scheme = $aurl['scheme'] . '://';
        if (strncmp($scheme, $location, strlen($scheme)) === 0)
            return $location;
        $url = $scheme . $aurl['host'];
        if (strncmp($location, '/', 1) === 0) {
            $url .= $location;
        } else {
            $query = dirname($aurl['query']);
            if (substr($aurl['query'], -1) == '/') {
                $url .= $aurl['query'] . $location;
            } else {
                $url .= ($query == '/' ? $query : $query . '/') . $location;
            }
        }
        return $url;
    }
    /**
     * 解析URL
     *
     * @param  $url
     * @return mixed
     */
    public static function parse_url($url){
        $referer = array();
        $aurl    = parse_url($url);
        $aurl['scheme']= isset($aurl['scheme']) ? $aurl['scheme'] : 'http';
        $aurl['host']  = isset($aurl['host']) ? $aurl['host'] : '';
        $aurl['port']  = isset($aurl['port']) ? intval($aurl['port']) : 80;
        $aurl['path']  = isset($aurl['path']) ? $aurl['path'] : '/';
        $aurl['query'] = isset($aurl['query']) ? '?'.$aurl['query'] : '';
        foreach(array('scheme','host','port','path','query') as $k) {
            if ($k=='port' && $aurl[$k]==80) {
                continue;
            } elseif ($k=='scheme') {
                $referer[$k] = $aurl[$k].'://';
            } elseif($k=='port') {
                $referer[$k] = ':'.$aurl[$k];
            } else {
                $referer[$k] = $aurl[$k];
            }
        }
        $aurl['referer'] = implode('',$referer);
        return $aurl;
    }
    /**
     * 解析 header
     *
     * @param string|array $headers
     * @return array
     */
    private function parse_header($headers) {
        // split headers, one per array element
        if ( is_string($headers) ) {
            // tolerate line terminator: CRLF = LF (RFC 2616 19.3)
            $headers = str_replace("\r\n", "\n", $headers);
            // unfold folded header fields. LWS = [CRLF] 1*( SP | HT ) <US-ASCII SP, space (32)>, <US-ASCII HT, horizontal-tab (9)> (RFC 2616 2.2)
            $headers = preg_replace('/\n[ \t]/', ' ', $headers);
            // create the headers array
            $headers = explode("\n", $headers);
        }

        $response = array('code' => 0, 'message' => '');

        // If a redirection has taken place, The headers for each page request may have been passed.
        // In this case, determine the final HTTP header and parse from there.
        $count = count($headers)-1;
        for ( $i = $count; $i >= 0; $i-- ) {
            if ( !empty($headers[$i]) && false === strpos($headers[$i], ':') ) {
                $headers = array_splice($headers, $i);
                break;
            }
        }

        $cookies = array();
        $new_headers = array();
        foreach ( $headers as $temp_header ) {
            if ( empty($temp_header) )
                continue;

            if ( false === strpos($temp_header, ':') ) {
                list( , $response['code'], $response['message']) = explode(' ', $temp_header, 3);
                continue;
            }

            list($key, $value) = explode(':', $temp_header, 2);

            if ( !empty( $value ) ) {
                $key = strtolower( $key );
                if ( isset( $new_headers[$key] ) ) {
                    if ( !is_array($new_headers[$key]) )
                        $new_headers[$key] = array($new_headers[$key]);
                    $new_headers[$key][] = trim( $value );
                } else {
                    $new_headers[$key] = trim( $value );
                }
                if ( 'set-cookie' == strtolower( $key ) )
                    $cookies[] = $this->parse_cookie( $value );
            }
        }

        return array('response' => $response, 'headers' => $new_headers, 'cookies' => $cookies);
    }
    /**
     * 解析 cookie
     *
     * @param string|array $data
     * @return array|bool
     */
    private function parse_cookie($data) {
        $result = array();
        if ( is_string( $data ) ) {
            // Assume it's a header string direct from a previous request
            $pairs = explode( ';', $data );

            // Special handling for first pair; name=value. Also be careful of "=" in value
            $name  = trim( substr( $pairs[0], 0, strpos( $pairs[0], '=' ) ) );
            $value = substr( $pairs[0], strpos( $pairs[0], '=' ) + 1 );
            $result['name']  = $name;
            $result['value'] = urldecode( $value );
            array_shift( $pairs ); //Removes name=value from items.

            // Set everything else as a property
            foreach ( $pairs as $pair ) {
                $pair = rtrim($pair);
                if ( empty($pair) ) //Handles the cookie ending in ; which results in a empty final pair
                    continue;

                list( $key, $val ) = strpos( $pair, '=' ) ? explode( '=', $pair ) : array( $pair, '' );
                $key = strtolower( trim( $key ) );
                if ( 'expires' == $key )
                    $val = strtotime( $val );
                $result[$key] = $val;
            }
        } else {
            if ( !isset( $data['name'] ) )
                return false;

            // Set properties based directly on parameters
            $result['name']   = $data['name'];
            $result['value']  = isset( $data['value'] ) ? $data['value'] : '';
            $result['path']   = isset( $data['path'] ) ? $data['path'] : '';
            $result['domain'] = isset( $data['domain'] ) ? $data['domain'] : '';

            if ( isset( $data['expires'] ) )
                $result['expires'] = is_int( $data['expires'] ) ? $data['expires'] : strtotime( $data['expires'] );
            else
                $result['expires'] = null;
        }
        return $result;
    }
    /**
     * Decompression of deflated string.
     *
     * Will attempt to decompress using the RFC 1950 standard, and if that fails
     * then the RFC 1951 standard deflate will be attempted. Finally, the RFC
     * 1952 standard gzip decode will be attempted. If all fail, then the
     * original compressed string will be returned.
     *
     * @param  $compressed
     * @return bool|string
     */
    private function decompress( $compressed) {
        if ( empty($compressed) )
            return $compressed;

        if ( false !== ( $decompressed = gzinflate( $compressed ) ) )
            return $decompressed;

        if ( false !== ( $decompressed = gzuncompress( $compressed ) ) )
            return $decompressed;

        if ( false !== ( $decompressed = gzdecode( $compressed ) ) )
            return $decompressed;

        return $compressed;
    }
    /**
     * decode a string that is encoded w/ "chunked' transfer encoding
     * as defined in RFC2068 19.4.6
     *
     * @param string $buffer
     * @return string
     */
    public static function decode_chunked($buffer) {
        $length = 0;
        $newstr = '';
        // read chunk-size, chunk-extension (if any) and CRLF
        // get the position of the linebreak
        $chunkend   = strpos($buffer,"\r\n") + 2;
        $chunk_size = hexdec(trim(substr($buffer,0,$chunkend)));
        $chunkstart = $chunkend; $new = '';
        // while (chunk-size > 0) {
        while ($chunk_size > 0) {

            $chunkend = strpos( $buffer, "\r\n", $chunkstart + $chunk_size);

            // Just in case we got a broken connection
            if ($chunkend == false) {
                $chunk = substr($buffer,$chunkstart);
                // append chunk-data to entity-body
                $new .= $chunk;
                $length += strlen($chunk);
                break;
            }

            // read chunk-data and CRLF
            $chunk  = substr($buffer,$chunkstart,$chunkend-$chunkstart);
            // append chunk-data to entity-body
            $newstr.= $chunk;
            // length := length + chunk-size
            $length += strlen($chunk);
            // read chunk-size and CRLF
            $chunkstart = $chunkend + 2;

            $chunkend = strpos($buffer,"\r\n",$chunkstart)+2;
            if ($chunkend == false) {
                break; //Just in case we got a broken connection
            }
            $chunk_size = hexdec(trim(substr($buffer,$chunkstart,$chunkend-$chunkstart)));
            $chunkstart = $chunkend;
        }
        return $newstr;
    }
    /**
     * 查询HTTP状态的描述
     *
     * @param int $code HTTP status code.
     * @return string Empty string if not found, or description if found.
     */
    public static function status_desc( $code ) {
        $code = abs(intval($code));
        $header_desc = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',

            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            226 => 'IM Used',

            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'Reserved',
            307 => 'Temporary Redirect',

            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            426 => 'Upgrade Required',

            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            510 => 'Not Extended'
        );

        if ( isset( $header_desc[$code] ) )
            return $header_desc[$code];
        else
            return '';
    }
}
