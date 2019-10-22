<?php
/**
 * Created by PhpStorm.
 * User: icon
 * Date: 2019/10/22
 * Time: 下午2:04
 */
if(!function_exists('image_url'))
{
    function image_url($url)
    {
        if(empty($url))        {
            return $url;
        }
        $path = parse_url($url);
return '/public';
        if(empty($path['host']))
        {
            $url = $url[0] == '/'? config('filesystems.disks.image.url').$url:config('filesystems.disks.image.url').'/'.$url;
        }

        return $url;
    }
}
