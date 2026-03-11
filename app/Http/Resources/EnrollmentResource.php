<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'     => $this->id,
            'course' => new CourseResource($this->whenLoaded('course')),
            'grade'  => new GradeResource($this->whenLoaded('grade')),
        ];
    }
}