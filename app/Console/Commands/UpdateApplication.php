<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Source\Entity\User\Models\User;
use function Source\Lib\artwooAddImageWatermark;

class UpdateApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-application';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run scripts before up application after update version';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Mark artworks with watermark
        $notMarked = DB::query()->select('*')->from('files')->whereIn('id', function(Builder $query) {
            $query->select('max_id')
                ->from(function(Builder $subquery) {
                    $subquery->select('contenthash', DB::raw('MAX(id) as max_id'))
                        ->from('files')
                        ->groupBy('contenthash');
                }, 'f_sub');
        })->where('component', '=', 'artwork')->get()->all();

        foreach ($notMarked as $row) {
            $user = User::find($row->user_id);

            if (empty($user)) {
                continue;
            }

            artwooAddImageWatermark($row, $user);
        }
    }
}
