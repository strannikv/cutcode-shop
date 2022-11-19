<?php

namespace Support\Testing;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

class FakerImageProvider extends Base
{

    public function fixturesImage(string $fixturesDir, string $storageDir)
    {
        $storage = Storage::disk('images');

        if (!Storage::exists($storageDir)) {
            $storage->makeDirectory($storageDir);
        }


        $file = $this->generator->file(base_path("tests/Fixtures/Images/$fixturesDir"),
            $storage->path($storageDir),
        false
        );

        return 'storage/images/' . trim($storageDir, '/').'/'.$file;
    }

}
