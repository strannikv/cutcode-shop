<?php

namespace App\Support\Testing;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

class FakerImageProvider extends Base
{

    public function fixturesImage(string $fixturesDir, string $storageDir)
    {
        if (!Storage::exists($storageDir)) {
            Storage::makeDirectory($storageDir);
        }


        $file = $this->generator->file(base_path("tests/Fixtures/Images/$fixturesDir"),
        Storage::path($storageDir),
        false
        );

        return 'storage/' . trim($storageDir, '/').'/'.$file;
    }

}
