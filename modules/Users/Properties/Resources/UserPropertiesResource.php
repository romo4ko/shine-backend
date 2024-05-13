<?php

declare(strict_types=1);

namespace Modules\Users\Properties\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Cities\Models\City;
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
            'gender' => $this->getProperty($this->gender),
            'city' => $this->getCity($this->city),
            'purpose' => $this->getProperty($this->purpose),
            'fs' => $this->getProperty($this->fs),
            'children' => $this->getProperty($this->children),
            'smoking' => $this->getProperty($this->smoking),
            'alcohol' => $this->getProperty($this->alcohol),
            'education' => $this->getProperty($this->education),
            'sign' => $this->getProperty($this->sign),
            'height' => $this->height,
            'tags' => $this->tags
        ];
    }

    public function getProperty(?int $id): ?String
    {
        $property = Property::where('id', $id)->first();
        if ($property) {
            return $property->name;
        }
        return null;
    }

    public function getCity(?int $id): ?String
    {
        $city = City::where('id', $id)->first();

        if ($city) {
            return $city->name;
        }
        return null;
    }
}
