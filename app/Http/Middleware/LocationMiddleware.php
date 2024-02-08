<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class LocationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->decodedPath();
        $req_data = [
            'ip' => $request->ip(),
            'client_name' => env('APP_NAME'),
            'ref_src' => 'facebook', //$request->get('ref_src'),
            'ref_mdm' => 'banner', //$request->get('ref_mdm'),
            'visited_url' => $route === '/' ? 'Home' : "/$route",
        ];
       

        $url_ws = env('APP_WS_URL') . '/api/visitors';
        $response = Http::post($url_ws, $req_data);
        if ($response->failed()) {
            $response_data = $response->json();
            $content_data = "<ul>";
            foreach($response_data as $key => $response_item) {
                $content_data .= "<li>$key : $response_item</li>\n";
            }
            $content_data .= "</ul>";
            $htmlContent = "<html><body>
                            <h3>An issue occured with visitors service!</h1>
                            <p>Here is the returned response:</p>
                            <p>$content_data</p>
                            </body></html>";
            Mail::raw($htmlContent, function(Message $message) use ($htmlContent) {
                $message->to(env('MAIL_FROM_ADDRESS'))
                        ->subject('An issue occured with visitors service')
                        ->html($htmlContent, 'text/html');
            });
        }
        return $next($request);
    }
}
