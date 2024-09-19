<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\CompiledRoute;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * @internal
 */
final class RouteCollectionSmokeAccessTest extends AbstractApiTestCase
{
    private const array GLOBALLY_IGNORE = ['gesdinet_jwt_refresh_token', 'app_logout'];

    /**
     * @return iterable<string, array{Route, CompiledRoute, string}>
     */
    public static function provideRouteCollectionSmokeAccessCases(): iterable
    {
        /** @var ?RouterInterface $router */
        /** @phpstan-ignore-next-line shipmonk.checkedExceptionInYieldingMethod */
        $router = self::getContainer()->get(RouterInterface::class);

        if ($router === null) {
            // @phpstan-ignore-next-line shipmonk.checkedExceptionInYieldingMethod
            throw new \LogicException('The router is not available.');
        }

        $routes = $router->getRouteCollection();

        self::ensureKernelShutdown();

        foreach ($routes as $routeName => $route) {
            if (\in_array($routeName, self::GLOBALLY_IGNORE, true)) {
                continue;
            }

            $methods = $route->getMethods();
            if ($methods === []) {
                $methods = ['GET'];
            }

            $compiledRoute = $route->compile(); // @phpstan-ignore-line shipmonk.checkedExceptionInYieldingMethod
            if ($compiledRoute->getPathVariables() !== [] && $compiledRoute->getPathVariables() !== ['tenantCode']) {
                continue;
            }

            if (! \in_array('GET', $methods, true)) {
                continue;
            }

            yield $routeName => [$route, $compiledRoute, $routeName];
        }
    }

    /**
     * @dataProvider provideRouteCollectionSmokeAccessCases
     */
    public function testRouteCollectionSmokeAccess(
        Route $route,
        CompiledRoute $compiledRoute,
        string $routeName,
    ): void {
        $this->loginAsUser(persist: true);
        $path = $route->getPath();
        $this->request('GET', $path);

        /** @var ?Response $response */
        $response = self::getClient()?->getResponse();

        if ($response === null) {
            $this->fail(\sprintf('Failed to get response for route %s (%s)', $path, $routeName));
        }

        if ($response->isSuccessful() === false) {
            $this->fail(
                \sprintf(
                    '[HTTP %d][%s] Failed to call route %s (%s) %s%s',
                    $response->getStatusCode(),
                    // @phpstan-ignore-next-line argument.type (false positive)
                    $route->getDefault('_controller'),
                    $path,
                    $routeName,
                    \PHP_EOL,
                    $response->getContent(),
                ),
            );
        }

        self::assertResponseIsSuccessful();
    }

    #[\Override]
    public function url(array $parameters = []): string
    {
        return 'dummy';
    }
}
