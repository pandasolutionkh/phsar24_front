<?php
function getTermCondition(){
    $setting = getSetting();
    return (isset($setting['term_condition']) ? $setting['term_condition'] : '');
}
function getAboutUs(){
    $setting = getSetting();
    return (isset($setting['about_us']) ? $setting['about_us'] : '');
}
function getAddress(){
    $setting = getSetting();
    return (isset($setting['address']) ? $setting['address'] : '');
}
function getFacebook(){
    $setting = getSetting();
    return (isset($setting['facebook']) ? $setting['facebook'] : '');
}
function getAboutFooter(){
    $setting = getSetting();
    return (isset($setting['about_footer']) ? $setting['about_footer'] : '');
}
function getEmail(){
    $setting = getSetting();
    return (isset($setting['email']) ? $setting['email'] : '');
}

function getAlert(){
    $setting = getSetting();
    return (isset($setting['alert']) ? $setting['alert'] : 0);
}

function getExpire(){
    $setting = getSetting();
    return (isset($setting['expire']) ? $setting['expire'] : 0);
}

function getSetting() {
    return DB::table('settings')->pluck('param_value', 'param_key');
}

function _t($txt,$page = 'layouts.'){
	return __($page.$txt);
}
function getDot(){
	return '...';
}

function extractYoutubeUrl($url){
	preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
	return $matches;
}

function getDisk(){
	$_driver = env('FILESYSTEM_DRIVER');
	return \Storage::disk($_driver);
}
function getUrlStorage($path){
	return getDisk()->url($path);
}

function getExistsStorage($path){
	return getDisk()->exists($path);
}

function getPathStorage($path){
	return getDisk()->path($path);
}

function getGenders(){
	$_data = ['1'=>'Male','0'=>'Female'];
	return $_data;
}

function getRequireStar($is_hidden = false){
    $_cls = '';
    if($is_hidden){
        $_cls = 'hidden';
    }
	return '<span class="text-danger" '.$_cls.'>*</span>';
}

function getPleaseSelect($msg = 'one') {
	return "Please select $msg";
}

if (! function_exists('words')) {
    /**
     * Limit the number of words in a string.
     *
     * @param  string  $value
     * @param  int     $words
     * @param  string  $end
     * @return string
     */
    function words($value, $words = 100, $end = '...')
    {
        return \Illuminate\Support\Str::words($value, $words, $end);
    }
}

if (! function_exists('chars')) {
    /**
     * Limit the number of words in a string.
     *
     * @param  string  $value
     * @param  int     $words
     * @param  string  $end
     * @return string
     */
    function chars($value, $limit = 100, $end = '...')
    {
        return \Illuminate\Support\Str::limit($value, $limit, $end);
    }
}

if(! function_exists('getUserId')){
	function getUserId(){
		$user = getUser();
        if($user){
        	return $user->id;
		}
    	return false;
    }
}

if(! function_exists('getUser')){
	function getUser(){
		$user = Auth::guard()->user();
        if($user){
        	return $user;
		}
    	return false;
    }
}

if(! function_exists('getFullName')){
    function getFullName(){
        $user = getUser();
        if($user){
            return $user->fullName();
        }
        return '';
    }
}

function createSlug($str, $delimiter = '-'){

    $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
    return $slug;

} 

if(! function_exists('showContentMore')){
    function showContentMore($str,$num_display = 15){
        $str = str_replace(array("\r\n","\r","\n"),"<br>", $str);
        $content = explode("<br><br>", $str);
        $res = '';
        $is_more = false;
        $res_more = '';
        foreach($content as $p){
            $_str = trim($p);
            $_str = addslashes($_str);
            $len = strlen($_str);
            $tmp_len = $num_display;
            $num_display = $num_display - $len;

            if($num_display <= 0 && !$is_more){
                $_substr = substrViaLineBreak($_str,5,$tmp_len);
                $_end = $_substr['end'];
                $res .= "<p class='see-more'>".$_substr['start'];
                if(trim($_end)){
                    $res .= "<span class='text-exposed-hide'>...</span>";
                    $res .= "<span class='text-exposed-show'>";
                    $res .= $_end;
                    $res .= "</span>";
                    $is_more = true;
                }
                $res .= "</p>";
            }else{
                if($is_more){
                    $res_more .= "<p>".$_str."</p>";
                }else{
                    $res .= "<p>".$_str."</p>";
                }
            }
        }

        if($is_more){
            $res .= "<div class='text-exposed-show'>$res_more</div>";
            $res .= "<a href='' class='btn-product-see-more'>See More</a>";
        }
        return $res;
    }
}

function substrViaLineBreak($str,$num_line = 5,$pos=15){
    $res = [];
    $_start = '';
    $_end = '';
    $_line = '<br>';
    $_space = ' ';

    $_content = explode('<br>', $str);
    foreach ($_content as $key => $value) {
        if($key < $num_line){
            if($_start){
                $_start .= $_line;
            }
            $_start .= $value;
        }else{
            if($_end){
                $_end .= $_line;
            }
            $_end .= $value;
        }
    }

    $_content = explode($_space, $_start);
    $_tmp_start = '';
    $_tmp_end = '';

    foreach($_content as $ind => $_item){
        if($ind > $pos){
            $_tmp_end .= $_space;
            $_tmp_end .= $_item;
        }else{
            if($_tmp_start){
                $_tmp_start .= $_space;
            }
            $_tmp_start .= $_item;
        }
    }



    return [
        'start' => $_tmp_start,
        'end' => "$_tmp_end $_end"
    ];
}

if(! function_exists('getNumberOfDays')){
    function getNumberOfDays($p_from,$p_to){
        
        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $p_to);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $p_from);
        $_min = $to->diffInMinutes($from);
        
        $res = $p_from->format('d F').' at '. $p_from->format('H:i');

        if($_min <= 0){
            $res = 'Just now';
        }else if($_min <= 60){
            $res = $_min . ' mins';
        }else{
            $_hour = $to->diffInHours($from);
            if($_hour <= 24){
                $res = $_hour . ' hrs'; 
            }
        }


        return $res;
    }
}


if(! function_exists('getPostPerPage')){
    function getPostPerPage(){
        $setting = getSetting();
        if(isset($setting['post_per_page'])){
            return $setting['post_per_page'];
        }
        return 15;
    }
}

