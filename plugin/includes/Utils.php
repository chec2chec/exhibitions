<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utils
 *
 * @author chec2chec
 */
class Utils {    
    public static function validateNumber($number) {
        $check = preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $number);
        if($check == true) {
                return $number;
        } else {
                return '';
        }
    }
    
    public static function takien_custom_tax1_slug_forward_slash( $rules ) {
        $slug = 'exhibitions/paintings';

        $rule = Array();
        $rule = array($slug.'/([^/]+)/?$' => $rules[$slug.'/([^/]+)/?$']) + $rule;
        $rule = array($slug.'/([^/]+)/page/?([0-9]{1,})/?$' => $rules[$slug.'/([^/]+)/page/?([0-9]{1,})/?$']) + $rule;
        $rule = array($slug.'/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => $rules[$slug.'/([^/]+)/(feed|rdf|rss|rss2|atom)/?$']) + $rule;
        $rule = array($slug.'/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => $rules[$slug.'/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$']) + $rule;

        $rules = $rule + $rules;
        return $rules;
    }
    
    public static function takien_custom_tax2_slug_forward_slash( $rules ) {
        $slug = 'exhibitions/authors';

        $rule = Array();
        $rule = array($slug.'/([^/]+)/?$' => $rules[$slug.'/([^/]+)/?$']) + $rule;
        $rule = array($slug.'/([^/]+)/page/?([0-9]{1,})/?$' => $rules[$slug.'/([^/]+)/page/?([0-9]{1,})/?$']) + $rule;
        $rule = array($slug.'/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => $rules[$slug.'/([^/]+)/(feed|rdf|rss|rss2|atom)/?$']) + $rule;
        $rule = array($slug.'/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => $rules[$slug.'/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$']) + $rule;

        $rules = $rule + $rules;
        return $rules;
    }
}
