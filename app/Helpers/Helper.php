<?php

// This class file to define all general functions

namespace App\Helpers;

use App;
use App\Models\MediaManager;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Helper
{

    static function formatDate($date = "")
    {
        if ($date != "") {
            $format = env("DATE_FORMAT", "Y-m-d");
            return date($format, strtotime($date));
        }
        return "";
    }

    static function jsDateFormat()
    {
        $format = env("DATE_FORMAT", "Y-m-d");
        $format = str_replace("Y", "YYYY", $format);
        $format = str_replace("m", "MM", $format);
        $format = str_replace("d", "DD", $format);
        return $format;
    }

    public static function getMediaUid($file_name)
    {
        return $media_uid = MediaManager::where('file_name', $file_name)->pluck('media_uid')->first();
    }

    public static function getMediaName($file_name)
    {
        return $media_uid = MediaManager::where('media_uid', $file_name)->pluck('file_name')->first();
    }

    public static function getMediaExt($file_name)
    {
        return $media_uid = MediaManager::where('file_name', $file_name)->pluck('file_ext')->first();
    }

    public static function getMediaPath($file_name)
    {
        return $media_uid = MediaManager::where('file_name', $file_name)->pluck('path')->first();
    }

    public static function getSuperScript($string)
    {
        $temp = '';

        foreach (explode(" ", $string) as $value) {

            if (preg_match('/\d+([a-zA-Z]+)/', $value, $matches)) {

                if ($matches[1] == "th") {
                    $temp .= " " . str_replace($matches[0], filter_var($matches[0], FILTER_SANITIZE_NUMBER_INT) . '<sup>th</sup>', $value);
                } elseif ($matches[1] == "st") {
                    $temp .= " " . str_replace($matches[0], filter_var($matches[0], FILTER_SANITIZE_NUMBER_INT) . '<sup>st</sup>', $value);
                } elseif ($matches[1] == "nd") {
                    $temp .= " " . str_replace($matches[0], filter_var($matches[0], FILTER_SANITIZE_NUMBER_INT) . '<sup>nd</sup>', $value);
                } else {
                    $temp .= " " . $value;
                }
            } else {
                $temp .= " " . $value;
            }
        }

        return $temp;
    }

    public static function getDateFormat($start_date, $end_date)
    {
        $start_date_month = Carbon::parse($start_date)->format('F');
        $end_date_month = Carbon::parse($end_date)->format('F');
        if ($start_date_month == $end_date_month) {
            if ($start_date == $end_date)
                return Carbon::parse($end_date)->format('d F Y');
            return Carbon::parse($start_date)->format('d') . ' - ' . Carbon::parse($end_date)->format('d F Y');
        } else {
            return Carbon::parse($start_date)->format('d F Y') . ' - ' . Carbon::parse($end_date)->format('d F Y');
        }
    }
    public static function removeStyleTag($story_desc)
    {
        $story_desc = explode('</style>', $story_desc);
        if (isset($story_desc[1]))
            $story_desc = strip_tags($story_desc[1]);
        else
            $story_desc = strip_tags($story_desc[0]);

        return Str::limit($story_desc, 150);
    }
}
