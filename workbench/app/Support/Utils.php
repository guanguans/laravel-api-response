<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Workbench\App\Support;

use Illuminate\Support\Facades\Artisan;

class Utils
{
    public const CONSOLE_OUTPUT_PHRASE = 'This is a console output example.';
    public const GENERAL_OUTPUT_PHRASE = 'This is a general output example.';
    public const JSON_OUTPUT_PHRASE = 'This is a json output example.';

    /**
     * @see \Illuminate\Foundation\Console\StorageLinkCommand
     */
    public static function links(array $links, array $parameters = []): int
    {
        $originalLinks = config('filesystems.links', []);

        config()->set('filesystems.links', $links);

        $status = Artisan::call('storage:link', $parameters + [
            '--ansi' => true,
            '--verbose' => true,
        ]);

        config()->set('filesystems.links', $originalLinks);

        // echo Artisan::output();

        return $status;
    }
}
