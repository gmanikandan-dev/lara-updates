<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /* Scenerio 1 : fixed null coalescing operator Implement Date: Jun 11th 2024 */
        $array['a'] = 1;
        $b = $array['b'] ?? 2; // works fine
        $b = (array) $array['b'] ?? 2; // WARNING  Undefined array key "b".

        /* Scenerio 2 : fixed indexed array filter In the table, we have product_id
           like [0=>1234,1=>7890]
        */
        YourModel::where('product_id', 1234)->first(); // for single
        YourModel::where('product_id', [1234, 7890])->first(); // for multiple

    }
}
