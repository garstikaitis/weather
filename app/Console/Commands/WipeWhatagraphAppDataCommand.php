<?php

namespace App\Console\Commands;

use Throwable;
use App\API\WhatagraphClient;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class WipeWhatagraphAppDataCommand extends Command
{
    public function __construct(private WhatagraphClient $apiClient)
    {
        parent::__construct();
    }

    protected $signature = "wipe-wg";
    protected $description = "Deletes integration metric, dimension and integration source data for external app in Whatagraph";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $appId = config(
                "integrations.integrator.whatagraph.external_app_id"
            );

            $metrics = $this->getMetrics();
            $dimensions = $this->getDimensions();
            $sourceData = $this->getSourceData();

            $metricsCount = count($metrics);
            $dimensionsCounts = count($dimensions);
            $sourceDataCount = count($sourceData);

            if (!$metricsCount && !$dimensionsCounts && !$sourceDataCount) {
                $this->info("No data to delete in app: {$appId}");
                return Command::SUCCESS;
            }

            $totalAdvancementBar =
                $metricsCount + $dimensionsCounts + $sourceDataCount;
            $this->output->progressStart($totalAdvancementBar);

            [$metricIds, $dimensionIds, $sourceDataIds] = $this->getEntityIds([
                $metrics,
                $dimensions,
                $sourceData,
            ]);

            if ($metricsCount) {
                $this->output->progressAdvance();
                $this->info(" Deleting metrics");
                $this->deleteMetrics($metricIds);
            }
            if ($dimensionsCounts) {
                $this->output->progressAdvance();
                $this->info(" Deleting dimensions");
                $this->deleteDimensions($dimensionIds);
            }
            if ($sourceDataCount) {
                $this->output->progressAdvance();
                $this->info(" Deleting source data");
                $this->wipeSourceData($sourceDataIds);
            }

            $this->output->progressFinish();
            $this->info("Finished wiping data in app: {$appId}");
            return Command::SUCCESS;
        } catch (Throwable $e) {
            return Command::FAILURE;
        }
    }

    private function getMetrics(): mixed
    {
        return $this->apiClient->getIntegrationMetrics();
    }

    private function getDimensions(): mixed
    {
        return $this->apiClient->getIntegrationDimensions();
    }

    private function getSourceData(): mixed
    {
        return $this->apiClient->getIntegrationSourceData();
    }

    private function deleteMetrics(array $metricIds): void
    {
        $this->apiClient->deleteIntegrationMetrics($metricIds);
    }
    private function deleteDimensions(array $dimensionIds): void
    {
        $this->apiClient->deleteIntegrationDimensions($dimensionIds);
    }
    private function wipeSourceData(array $sourceDataIds): void
    {
        $this->apiClient->deleteIntegrationSourceData($sourceDataIds);
    }

    /**
     * Plucks value by key from array and converts to collection
     *
     * @return Collection
     */
    private function getEntityIds(array $data, string $key = "id"): Collection
    {
        $collection = collect();
        foreach ($data as $value) {
            $collection->push(array_column($value, $key));
        }
        return $collection;
    }
}
