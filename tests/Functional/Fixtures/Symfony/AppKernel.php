<?php

namespace FOS\HttpCache\Tests\Functional\Fixtures\Symfony;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * A simplistic kernel that is actually the whole application.
 */
class AppKernel implements HttpKernelInterface
{
    /**
     * This simplistic kernel handles the request immediately inline.
     *
     * {@inheritDoc}
     */
    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        switch ($request->getPathInfo()) {
            case '/cache':
                $response = new Response(microtime(true));
                $response->setCache(['max_age' => 3600, 'public' => true]);

                return $response;
            case '/negotiation':
                $response = new Response(microtime(true));
                $response->setCache(['max_age' => 3600, 'public' => true]);
                $response->headers->set('Content-Type', $_SERVER['HTTP_ACCEPT']);
                $response->setVary('Accept');

                return $response;
        }

        return new Response('Unknown request '.$request->getPathInfo(), 404);
    }
}
