<?php

namespace App\Console\Commands;

use Throwable;
use App\API\WhatagraphClient;
use Illuminate\Console\Command;

class PrepareWhatagraphAppCommand extends Command
{
    const TOTAL_STEPS = 2;
    protected $signature = "prepare-wg";
    protected $description = "Creates integration metric and dimension for given external app in Whatagraph";

    public function __construct(private WhatagraphClient $apiClient)
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
        try {
            $this->output->progressStart(self::TOTAL_STEPS);
            $this->createIntegrationMetric();
            $this->createIntegrationDimension();
            $this->output->progressFinish();
            $this->info(" Successfuly created dimension and metric");
            return Command::SUCCESS;
        } catch (Throwable $e) {
            return Command::FAILURE;
        }
    }

    private function createIntegrationMetric(): void
    {
        $this->info(" Creating metric with external id: average_temp");
        $this->apiClient->createIntegrationMetric();
        $this->output->progressAdvance();
    }
    private function createIntegrationDimension(): void
    {
        $this->info(" Creating dimension with external id: city");
        $this->apiClient->createIntegrationDimension();
        $this->output->progressAdvance();
    }
}
