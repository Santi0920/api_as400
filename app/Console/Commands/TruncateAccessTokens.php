<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateAccessTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'truncate:access_tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate the oauth_access_tokens table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('oauth_access_tokens')->truncate();
        $this->info('Table oauth_access_tokens truncated successfully.');
    }
}
