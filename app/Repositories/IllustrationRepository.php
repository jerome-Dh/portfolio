<?php
namespace App\Repositories;

use App\Models\{Illustration, Experience};

/**
 * Manager class for Illustration model
 *
 * @package App\Repositories
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 05/10/2020 21:47
 */
class IllustrationRepository extends ResourceRepository
{

    /**
     * Constructor
     *
     * @param $model - Illustration
     */
    public function __construct(Illustration $model)
    {
        $this->model = $model;
    }

    /**
     * Find a Illustration by image
     *
     * @param $value - Value
     *
     * @return Illustration|null
     */
    public function findByImage($value)
    {
        return $this->model->where('image', $value)->first();
    }

    /**
     * Find the illustrations
     *
     * @param $q - Query search
     * @param $sort - Field assorting
     * @param $order - ASC/DESC
     * @param $nb - Max result
     * @param $current - Number of current page
     *
     * @return array|null
     */
    public function findIllustration(
        $q = '',
        $sort = 'image',
        $order = 'ASC',
        $nb = 1000,
        $current = 1)
    {
        $clone = clone $this->model;

        //Find the query term in all table field
        if($q)
        {
            $clone = $clone->where(function ($query) use ($q) {

				$query->where('image', 'LIKE', '%'.$q.'%');

            });
        }

        $sort = $sort ? $sort : 'image';
        $order = $order ? $order : 'ASC';

        return $clone->orderBy($sort, $order)
                    ->paginate($nb, ['*'], 'page', $current);

    }

    /**
     * Get list experiences for select
     *
     * @return array
     */
	public function getExperienceForSelect() {
	    $experiences = [];
	    foreach (Experience::orderBy('year', 'DESC')->get() as $experience) {
	        $experiences[$experience->id] = ucfirst($experience->name_en).' - '.$experience->year;
        }

        return $experiences;
    }
}
