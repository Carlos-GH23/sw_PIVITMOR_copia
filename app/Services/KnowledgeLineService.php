<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class KnowledgeLineService
{
    public function store(Model $model, array $knowledgeLines): void
    {
        if (empty($knowledgeLines)) {
            return;
        }

        foreach ($knowledgeLines as $line) {
            $model->knowledgeLines()->create($line);
        }
    }

    public function sync(Model $model, array $knowledgeLines): void
    {
        $model->knowledgeLines()->delete();
        $this->store($model, $knowledgeLines);
    }
}
