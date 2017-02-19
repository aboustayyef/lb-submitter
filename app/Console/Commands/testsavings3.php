<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Storage;
use \Image;

class testsavings3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $i = Image::make('http://pbs.twimg.com/profile_images/753634547854606336/HOhl00ph.jpg');
        $result = Storage::disk('s3')->put( 'test.jpg', $i->encode('jpg')->stream()->__toString());
    }
}
