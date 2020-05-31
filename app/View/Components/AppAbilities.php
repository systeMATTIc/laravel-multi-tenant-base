<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppAbilities extends Component
{
    /**
     * The abilities configuration for a subject.
     *
     * @var array
     */
    public $abilities;

    /**
     * The main abilities key name for mapping updates in parent component.
     *
     * @var string
     */
    public $abilitiesKey;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($abilities, $abilitiesKey)
    {
        $this->abilities = $abilities;

        $this->abilitiesKey = $abilitiesKey;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.app-abilities');
    }
}
