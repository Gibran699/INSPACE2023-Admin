<?php

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

// function to replace route with value set in key with route as array key
function getRouteDescription($key) {
    $list = [
        'comittees' => 'Menu Comiteess',
        'participants' => 'Menu Participant',
        'programs' => 'Menu Programs',
        'announcements' => 'Menu Announcement',
        'medpart' => 'Menu Medpart',
        'faq' => 'Menu Faq',
        'deskripsi' => 'Menu Deskripsi',
        'active' => 'Menu Active Program',
        'agenda' => 'Menu Agenda',
        'addon-variant' => 'Menu Addon Variant'
    ];

    if (!array_key_exists(strtolower($key), $list)) return $key;

    return $list[strtolower($key)];
}


// function to get all route with prefix
function getRoutes($ignoreApi = true,

    /** Specific vendor route may be exists, add in this below */
    $ignorePrefix = ['home', 'permission','division', 'activity-log'],

    /** Ignore slash after prefix */
    $ignoreSlashPrefix = true,

    /** Append routes */
    $appendRoutes = ['active']
)
{

    /** Added in the first place */
    $ignorePrefixTemplate = [
        'sanctum', 'call', 'test', 'login', 'logout'
    ];

    $ignorePrefixTemplate = array_merge($ignorePrefixTemplate, $ignorePrefix);

    $routes = [];


    foreach(Route::getRoutes() as $r) {
        $uri = $r->uri();
        $prefix = $r->getPrefix();
        // Ignore api prefix
        if ($ignoreApi) {
            if (preg_match("/api\//i", $uri)) continue;
        }

        // Ignore underscore prefix
        if ($uri[0] == '_') continue;

        // Ignore slash only prefix
        if ($uri[0] == '/') continue;

        // Ignore specific prefix
        $foundedIgnorePrefix = false;
        foreach($ignorePrefixTemplate as $ipt) {
            $prefix = "/$ipt/i";
            if (preg_match($prefix, $uri)) {
                $foundedIgnorePrefix = true;
                break;
            }
        }
        if ($foundedIgnorePrefix) continue;

        // Ignore slash after prefix
        if ($ignoreSlashPrefix && Str::contains($uri, '/')) continue;

        // Prevent duplicated
        if (in_array($uri, $routes)) continue;

        $routes[] = $r->uri();
    }

    $routes = array_merge($routes, $appendRoutes);

    return $routes;
}

// function for checking if logged user have access in spesific menu
function accessMenu($menu)
{
    $accessmenu = isset(auth()->guard('comittee')->user()->division->accessmenu) ? json_decode(auth()->guard('comittee')->user()->division->accessmenu) : [];
    return in_array($menu, $accessmenu);
}

// function to assign comittee action to log
function addToLog($subject)
{
    ActivityLog::create([
        'subject' => $subject,
        'url' => request()->fullUrl(),
        'method' => request()->method(),
        'comittee_id' => auth()->guard('comittee')->user()->id
    ]);
}
