<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Documents\Document;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createDocuments();
    }

    public function createDocuments(): void
    {
        $documents = [
            [
                'name' => 'Политика конфиденциальности',
                'slug' => 'policy',
                'text' => file_get_contents(__DIR__ . '/documents/policy.txt'),
            ],
            [
                'name' => 'Пользовательское соглашение',
                'slug' => 'agreement',
                'text' => file_get_contents(__DIR__ . '/documents/policy.txt'),
            ],
        ];

        foreach ($documents as $document) {
            Document::query()->create($document);
        }
    }
}
