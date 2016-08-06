<?php

class base
{
    
    /*
     * @METHOD  redirect
     * @DESC    instead of writing the header function so many times,
     * @DESC    we'll just use this redirect function
     */
    
    public function redirect($url) {
        header('Location: '. $url);
        exit();
    }
    
    /*
     * @METHOD  country
     * @DESC    get the visitors country
     */
    
    public function country(){
        $ch = curl_init('http://api.hostip.info/?ip='. $_SERVER['REMOTE_ADDR']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $xml = @curl_exec($ch);
        curl_close($ch);
        
        $dom = new DOMDocument();
        @$dom->loadXML($xml);
        
        return $dom->getElementsByTagName('countryName')->item(0)->nodeValue;
    }
    
    /*
     * @METHOD  getPageName
     * @DESC    returns the name of the page the viewer is on
     */
	
    public function getPageName() {
        $page = preg_replace('#\/(.+)\/#', '', $_SERVER['PHP_SELF']);
        $page = str_replace('/', null, $page);
        return $page;
    }
    
    /*
     * @METHOD  br2nl
     * @DESC    converts break tags to \n (new lines)
     */
    
    public function br2nl($string){
        return str_replace('&lt;br /&gt;', '<br />', $string);
    }
    
    /*
     * @METHOD  remBr
	 * @DESC	get rid of <br /> (such as when you edit a post)
     */
    
    public function remBr($content){
        return str_replace('<br />', null, $content);
    }
    
    /*
     * @METHOD  seconds_to_time
     * @DESC    converts an int (seconds) to a string, E.G:
     * @DESC    4 Days 3 Hours 26 Seconds
     */
    
    public function seconds_to_time($seconds){
            if($seconds == 0) return 'Never.';
            
            //time units
            $units = array('day' => 86400, 'hour' => 3600, 'minute' => 60, 'second' => 1);

            foreach($units as $name => $key)
            {
                    if($k = intval($seconds / $key))
                    {
                            ($k > 1) ? $s .= $k.' '.$name.'s ' : $s .= $k.' '.$name.' ';

                            //update seconds
                            $seconds -= $k*$key;
                    }
            }

            return $s;
    }
	
	/*
		@METHOD	writeToFile
		@DESC	Does what it says - writes to a file
	*/
    
    public function appendToFile($file, array $string){
            $file_handle = fopen($file, 'a');
            
            foreach($string as $string_to_write)
            {
                fwrite($file_handle, '['. date('M-d-Y h:m:s') .'] '.$string_to_write."\n");
            }

            fclose($file_handle);
    }
    
    /*
     * @METHOD  shorten
     * @DESC    shortens the string to the length, then returns it
     * @PARAM   $cutoff  1 = return without words being cut-off
     */
    
    public function shorten($string, $length, $cutoff = false){
        if(!$cutoff)
        {
            return substr($string, 0, (int) $length);
        }
        else
        {
            $string = substr($string, 0, (int) $length);
            return $string = substr($string, 0, strrpos($string, ' '));
        }
            
    }
}
?>