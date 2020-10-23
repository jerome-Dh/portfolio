<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource Skill
 *
 * @package App\Http\Resources
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:55
 */
class SkillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
	 *
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}