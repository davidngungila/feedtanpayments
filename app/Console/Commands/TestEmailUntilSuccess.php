<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:test-email-until-success')]
#[Description('Command description')]
class TestEmailUntilSuccess extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
