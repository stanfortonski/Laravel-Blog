<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void{
        parent::setUp();
        DB::beginTransaction();
    }

    public function tearDown(): void{
        DB::rollback();
        $this->beforeApplicationDestroyed(function(){
            DB::disconnect();
        });
        parent::tearDown();
    }
}
