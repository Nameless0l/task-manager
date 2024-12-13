<?php



namespace App\DTO;

use App\Http\Requests\TaskRequest;
readonly class TaskDTO
{

    public function __construct(
        public? int $id,
 public? string $title,
 public? string $status,

    ) {}

    public static function fromRequest(TaskRequest $request): self
    {
        return new self(
            id : $request->get('id'),
 title : $request->get('title'),
 status : $request->get('status'),

        );
    }
}