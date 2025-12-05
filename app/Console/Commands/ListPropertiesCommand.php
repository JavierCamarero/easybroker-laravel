<?php

namespace App\Console\Commands;

use App\Features\Properties\UseCases\ListAllProperties;
use Illuminate\Console\Command;

class ListPropertiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easybroker:list-properties';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Print all property titles from EasyBroker API';

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
    public function handle(ListAllProperties $listAllProperties)
    {
        $properties = $listAllProperties->execute();

        foreach ($properties as $property) {
            $title = $property->getTitle();
            $this->line($title);
        }

        return self::SUCCESS;
    }
}
