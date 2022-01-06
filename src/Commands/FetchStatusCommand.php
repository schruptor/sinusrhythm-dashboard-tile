<?php

namespace Schruptor\Sinusrhythm\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Schruptor\Sinusrhythm\StatusStore;

class FetchStatusCommand extends Command
{
    protected $signature = 'dashboard:fetch-status';

    protected $description = 'Fetch sinusthythm.dev statuses';

    public function handle()
    {
        $this->info('Fetching sinusthythm.dev statuses...');


        $status = $this->getStatus(config('dashboard.tiles.sinusrhythm.uuids'));

        if (count($status)) {
            StatusStore::make()->setStatus($status);
        }

        $this->info('All done!');
    }

    private function getStatus(array $uuids): array
    {
        $statuses = [];

        foreach ($uuids as $uuid) {
            $response = Http::get("https://sinusrhythm.dev/api/status/{$uuid}");

            if (! $response->ok()) {
                $statuses[$uuid][] = ['status' => "❌", 'job' => 'Error could not Fetch'];

                continue;
            }

            $formatedResponse = $this->format($response->json());

            $statuses[$formatedResponse['url']][] = $formatedResponse;
        }

        return $statuses;
    }

    public function format(array $response): array
    {
        return array_merge(
            $response,
            [
                'url' => config('dashboard.tiles.sinusrhythm.short-url') === false ? $response['url'] : preg_replace("(^https?://)", "", $response['url']),
                'status' => config('dashboard.tiles.sinusrhythm.emoji-status') === false ? $response['status'] : $this->getEmoji($response['status']),
                'job' => config('dashboard.tiles.sinusrhythm.without-prefix') === false ? $response['job'] : str_replace('php artisan ', '', $response['job']),
            ]
        );
    }

    private function getEmoji(string $status): string
    {
        return match ($status) {
            'new' => "✴️",
            'successful' => "✅",
            'failed' => "❌",
        };
    }
}
