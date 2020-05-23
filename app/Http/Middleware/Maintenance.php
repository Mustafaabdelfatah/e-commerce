<?php

namespace App\Http\Middleware;

use Closure;

class Maintenance
{

    public function handle($request, Closure $next)
    {
        if(setting()->status == 'open')
        {
            return $next($request);
        }
        else
        {
            return redirect('maintenance');
        }
    }
}
