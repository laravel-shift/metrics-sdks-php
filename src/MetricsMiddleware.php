<?php
namespace ReadMe;

class MetricsMiddleware
{
    /** @var Metrics */
    private $metrics;

    public function __construct()
    {
        $this->metrics = new Metrics(config('readme.api_key'), config('readme.group'), [
            'development_mode' => config('readme.development_mode', false),
            'blacklist' => config('readme.blacklist', []),
            'whitelist' => config('readme.whitelist', [])
        ]);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        $this->metrics->track($request, $response);

        return $response;
    }
}
