<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('isStringSet'))
{
    function isStringSet($var = '')
    {
        return $var!=='';
    }
}

if (!function_exists('myIsArray'))
{
    function myIsArray($data = array())
    {
        if(isset($data) && count($data) > 0 && !empty($data))
        {
            return $data;
        }
        else
        {
            return false;
        }
    }
}

if (!function_exists('myIsMultiArray'))
{
    function myIsMultiArray($data = array())
    {
        foreach($data as $key => $row)
        {
            if(count($row) != 0)
            {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('myInArray'))
{
    function myInArray($value = '', $stack = '')
    {
        if(myIsArray($stack) && isStringSet($value) && in_array($value, $stack))
        {
            return $value;
        }
        else
        {
            return false;
        }
    }
}

if(!function_exists('getUniqueLink'))
{
    function getUniqueLink($data = '')
    {
        $data = strtolower($data);
        $data = str_replace(' ', '-', $data);

        $data = preg_replace('/[^A-Za-z0-9\-]/', '', $data);

        $data = str_replace('--', '-', $data);

        return $data;
    }
}

if (!function_exists('isSession'))
{
    function isSession($value)
    {
        if(!is_null($value))
        {
            return $value;
        }
        else
        {
            return false;
        }
    }
}

if (!function_exists('isSessionVariableSet'))
{
    function isSessionVariableSet($value = '')
    {
        if($value !== '')
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

if (!function_exists('sortMultiArray'))
{
    function sortMultiArray($array = array(), $value = '')
    {
        if(isset($array))
        {
            for($i = 0;$i<count($array);$i++)
            {
                for($j = 0;$j<count($array);$j++)
                {
                    if($array[$i][$value] < $array[$j][$value])
                    {
                        $temp = $array[$i];
                        $array[$i] = $array[$j];
                        $array[$j] = $temp;
                    }
                }
            }
            return $array;
        }

    }
}

if (!function_exists('ReversesortMultiArray'))
{
    function ReversesortMultiArray($array = array(), $value = '')
    {
        if(isset($array))
        {
            for($i = 0;$i<count($array);$i++)
            {
                for($j = 0;$j<count($array);$j++)
                {
                    if($array[$i][$value] > $array[$j][$value])
                    {
                        $temp = $array[$i];
                        $array[$i] = $array[$j];
                        $array[$j] = $temp;
                    }
                }
            }
            return $array;
        }

    }
}
