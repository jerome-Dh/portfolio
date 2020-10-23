<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource Experience_technologie
 *
 * @package App\Http\Resources
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:55
 */
class Experience_technologieResource extends JsonResource
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
        $array = parent::toArray($request);
        $array['experience'] = $this->experience;
        $array['technologie'] = $this->technologie;
        return $array;
    }
}