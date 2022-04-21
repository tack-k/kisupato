<?php

namespace App\Console\Commands;

use App\Models\Admins\InformationSite;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PublishInformationSiteCommand extends Command {
    protected $signature = 'command:publish';

    protected $description = 'Publish information of Sites';

    public function handle() {
        $informationSites = InformationSite::getReservedInformationSites()->get();
        $currentTime = Carbon::now();
        foreach ($informationSites as $informationSite) {
            if ($currentTime->gte($informationSite['reserved_at'])) {
                $informationSite->update([
                    'status' => '0',
                    'posted_at' => $currentTime,
                    'reserved_at' => null,
                ]);
            }
        }
    }
}
