<?php

namespace App\Http\Livewire;

trait MapsAbilitiesForRoleCreation
{
    protected function getAllowedAbilitiesFrom($map)
    {
        return collect($map)->flatMap(function ($m) {
            $allowed = collect($m['abilities'])->filter(function ($c) {
                return $c['state'] == 'allow';
            });

            return $allowed->pluck('name');
        })->toArray();
    }

    protected function getMappedAbililites()
    {
        return collect($this->getConfig())->map(function ($conf) {

            $abilities = collect($conf['abilities'])->map(function ($ab) {
                $ab['state'] = '';
                return $ab;
            });

            $conf['abilities'] = $abilities->all();

            return $conf;
        })->map(function ($conf) {

            $abilityNames = $this->abilities->pluck('name');

            $presentAbilities = collect($conf['abilities'])->filter(function ($ab) use ($abilityNames) {
                return $abilityNames->contains($ab['name']);
            });

            $conf['abilities'] = $presentAbilities->all();

            return $conf;
        })->all();
    }
}
