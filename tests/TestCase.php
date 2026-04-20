<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\File;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $compiledPath = sys_get_temp_dir().DIRECTORY_SEPARATOR.'abd-testing-views'.DIRECTORY_SEPARATOR.str_replace('.', '_', uniqid('', true));

        File::ensureDirectoryExists($compiledPath);

        config(['view.compiled' => $compiledPath]);
    }
}
