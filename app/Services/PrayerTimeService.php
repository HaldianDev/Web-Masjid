<?php

namespace App\Services;

use App\Models\PrayerSchedule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PrayerTimeService
{
    protected string $defaultCityId = '1003'; // Lampung Selatan
    protected string $defaultCityName = 'Lampung Selatan';

    public function getTimings(string $dateString = null): array
    {
        $date = $dateString ? Carbon::parse($dateString) : Carbon::today();
        $dateStr = $date->toDateString();

        // 1. Check database cache
        $cached = PrayerSchedule::where('date', $dateStr)
            ->where('city', $this->defaultCityName)
            ->first();

        if ($cached) {
            return [
                'imsak' => $cached->imsak,
                'subuh' => $cached->subuh,
                'syuruk' => $cached->syuruk,
                'dzuhur' => $cached->dzuhur,
                'ashar' => $cached->ashar,
                'maghrib' => $cached->maghrib,
                'isya' => $cached->isya,
                'city' => $cached->city,
                'date' => $cached->date->format('Y-m-d'),
                'source' => 'db_cache'
            ];
        }

        // 2. Fetch from API
        try {
            $year = $date->format('Y');
            $month = $date->format('m');
            $day = $date->format('d');
            
            $url = "https://api.myquran.com/v2/sholat/jadwal/{$this->defaultCityId}/{$year}/{$month}/{$day}";
            $response = Http::timeout(3)->get($url);

            if ($response->successful() && $response->json('status') === true) {
                $jadwal = $response->json('data.jadwal');
                
                // Save to database cache
                $schedule = PrayerSchedule::create([
                    'city' => $this->defaultCityName,
                    'date' => $dateStr,
                    'imsak' => $jadwal['imsak'],
                    'subuh' => $jadwal['subuh'],
                    'syuruk' => $jadwal['terbit'], // 'terbit' is Shuruq
                    'dzuhur' => $jadwal['dzuhur'],
                    'ashar' => $jadwal['ashar'],
                    'maghrib' => $jadwal['maghrib'],
                    'isya' => $jadwal['isya'],
                ]);

                return [
                    'imsak' => $schedule->imsak,
                    'subuh' => $schedule->subuh,
                    'syuruk' => $schedule->syuruk,
                    'dzuhur' => $schedule->dzuhur,
                    'ashar' => $schedule->ashar,
                    'maghrib' => $schedule->maghrib,
                    'isya' => $schedule->isya,
                    'city' => $schedule->city,
                    'date' => $schedule->date->format('Y-m-d'),
                    'source' => 'api'
                ];
            }
        } catch (\Exception $e) {
            Log::warning("Failed to fetch prayer times from API: " . $e->getMessage());
        }

        // 3. Fallback hardcoded values (approximate Lampung Selatan times)
        return [
            'imsak' => '04:35',
            'subuh' => '04:45',
            'syuruk' => '06:00',
            'dzuhur' => '12:00',
            'ashar' => '15:20',
            'maghrib' => '17:55',
            'isya' => '19:05',
            'city' => $this->defaultCityName,
            'date' => $dateStr,
            'source' => 'fallback'
        ];
    }
}
