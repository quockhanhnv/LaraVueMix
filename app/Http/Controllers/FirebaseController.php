<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class FirebaseController extends Controller
{
    protected $database;

    public function __construct()
    {
        $this->database = $this->initDatabase();
    }

    public function index()
    {
        $reference = $this->database->getReference('blog/posts');
        $snapshot = $reference->getSnapshot();

        $value = $snapshot->getValue();
        dd($value);
    }

    protected function initDatabase()
    {
        $factory = (new Factory)->withServiceAccount(__DIR__.'/firebase_credentials.json')
            ->withDatabaseUri('https://notifications-760e1.firebaseio.com');
        return $factory->createDatabase();
    }

    public function store()
    {
        $this->database->getReference('blog/posts')
            ->set([
                'name' => 'My Application',
                'emails' => [
                    'support' => 'support@domain.tld',
                    'sales' => 'sales@domain.tld',
                ],
                'website' => 'https://app.domain.tld',
            ]);
    }
}
