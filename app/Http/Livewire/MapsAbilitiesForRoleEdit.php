<?php

namespace App\Http\Livewire;

/**
 * 
 */
trait MapsAbilitiesForRoleEdit
{
    protected function getMappedAbililites()
    {
        $currentRoleAbilities = $this->role->getAbilities()->pluck('name');

        return collect($this->getConfig())->map(function ($conf) use ($currentRoleAbilities) {

            $abilities = collect($conf['abilities'])->map(function ($ab) use ($currentRoleAbilities) {
                if ($currentRoleAbilities->contains($ab['name'])) {
                    $ab['state'] = 'allow';
                } else {
                    $ab['state'] = 'deny';
                }
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

    protected function getAllowedAbilitiesFrom($map)
    {
        return collect($map)->flatMap(function ($m) {
            $allowed = collect($m['abilities'])->filter(function ($c) {
                return $c['state'] == 'allow';
            });

            return $allowed->pluck('name');
        })->toArray();
    }
}
