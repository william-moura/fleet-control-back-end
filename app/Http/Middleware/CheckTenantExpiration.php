<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTenantExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = tenant();
        if (!$tenant) {
            return response()->json([
                'error' => 'Tenant not found',
                'message' => 'O ambiente não foi encontrado. Entre em contato com o suporte.'
            ], 404);
        }
        if ($tenant->expiration_date) {
            $expirationDate = \Carbon\Carbon::parse($tenant->expiration_date);

            // 4. Se a data atual for maior que a validade, bloqueia o acesso
            if (now()->greaterThan($expirationDate)) {
                
                // Se for uma requisição AJAX/API, retorna JSON
                if ($request->wantsJson()) {
                    return response()->json([
                        'error' => 'Subscription expired',
                        'message' => 'A assinatura deste ambiente expirou. Entre em contato com o suporte.'
                    ], 403);
                }

                // Se for web tradicional, você pode abortar ou redirecionar
                abort(403, 'Esta conta expirou. Por favor, regularize sua assinatura.');
            }
        }
        return $next($request);
    }
}
