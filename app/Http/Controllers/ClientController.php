<?php

namespace App\Http\Controllers;

use App\Repositories\ExperienceRepository;
use App\Repositories\SkillRepository;
use App\Repositories\WorkRepository;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{

    protected $nbPerPage = 10;

    /**
     * Home - About Me
     *
     * @param $lang
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function about($lang)
    {
        app()->setLocale($lang);
        return view('client.about');
    }

    /**
     * The experiences and works
     *
     * @param $lang
     * @param ExperienceRepository $experienceRepository
     * @param WorkRepository $workRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function experiencies($lang, ExperienceRepository $experienceRepository, WorkRepository $workRepository)
    {
        app()->setLocale($lang);
        $experiencies = $experienceRepository->getByYear();
        $works = $workRepository->getAllWorks();

        return view('client.experiencies', compact('experiencies', 'works'));
    }

    /**
     * Skills
     *
     * @param $lang
     * @param SkillRepository $skillRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function skills($lang, SkillRepository $skillRepository)
    {
        app()->setLocale($lang);
        $skills = $skillRepository->getAllSkills('ASC');

        return view('client.skills', compact('skills'));
    }

    /**
     * Others
     *
     * @param $lang
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function others($lang)
    {
        app()->setLocale($lang);

        $books = Storage::files('books');

        return view('client.others', compact('books'));
    }

    /**
     * The blog
     *
     * @param $lang
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\Views
     */
    public function blog($lang)
    {
        app()->setLocale($lang);

        $articles = [];
        return view('client.blog', compact('articles'));
    }
}
