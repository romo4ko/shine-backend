<?php
declare(strict_types= 1);
 
namespace Modules\Users\Properties\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Properties\Models\Property;

class UserPropertiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
			'text' => $this->text,
			'birthdate' => Carbon::parse($this->birthdate)->format('d.m.Y'),
			'age' => Carbon::parse($this->birthdate)->age,
			// 'sex' => 
			// 'city',
			// 'purpose',
			// 'fs',
			// 'children',
			// 'smoking',
			// 'alcohol',
			// 'education',
			// 'sign',
			// 'height',
			// 'tags',
        ];
    }
}