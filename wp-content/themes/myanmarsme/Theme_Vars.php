<?php
class Theme_Vars
{
    public static $styles = array();
    public static $scripts = array();    
    public static $scriptlets = array();
    public static $script_ready = array();
    
    
    public static function add_script($key, $script) {
        Theme_Vars::$scripts[$key] = $script;
    }
    
    public static function add_styles($styles) {
        Theme_Vars::$styles[] = $styles;
    }
    
    public static function add_scriptlets($scriptlet) {
        Theme_Vars::$scriptlets[] = $scriptlet;
    }
    
    public static function add_script_ready($script) {
        Theme_Vars::$script_ready[] = $script;
    }
}