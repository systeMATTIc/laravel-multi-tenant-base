<div class="w-full" x-data="{ tab: '' }" x-cloak>
    @foreach ($abilities as $key => $mappedAbility)
    <section class="shadow">
        <article class="border">
            <div class="border-l-2 border-transparent">
                <header class="flex justify-between items-center px-5 py-2 pl-8 pr-8 cursor-pointer select-none"
                    @click="tab != '{{ $mappedAbility['subject'] }}' ? tab = '{{ $mappedAbility['subject'] }}' : tab = '' ">
                    <span class="text-grey-darkest font-thin text-xl">
                        {{ $mappedAbility['subject'] }}
                    </span>
                    <div class="rounded-full border border-grey w-7 h-7 flex items-center justify-center">
                        <svg aria-hidden="true" class="" data-reactid="266" fill="none" height="24" stroke="#606F7B"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24"
                            width="24" xmlns="http://www.w3.org/2000/svg">
                            <polyline points="6 9 12 15 18 9">
                            </polyline>
                        </svg>
                    </div>
                </header>
            </div>
        </article>
        <article wire:ignore.self class="border-b" x-show="tab == '{{ $mappedAbility['subject'] }}'">
            <div class="border-l-2 border-r-2 bg-grey-lightest border-indigo-600">
                <div class="overflow-x-auto relative">
                    <div class="pl-8 pr-8 pb-5 text-grey-darkest inline-block min-w-full">
                        <ul class="pl-4">
                            @foreach ($mappedAbility['abilities'] as $configKey => $abilityConfig)
                            <li class="py-5 w-full border-b last:border-0 flex justify-between">
                                <p class="mr-12 sm:mr-0">{{ $abilityConfig['title'] }}</p>
                                <div class="flex">
                                    <label class="inline-flex items-center mr-12 cursor-pointer" @click.stop>
                                        <input @click.stop
                                            wire:model="{{ $abilitiesKey }}.{{ $key }}.abilities.{{ $configKey }}.state"
                                            type="radio" class="form-radio text-indigo-600"
                                            name="{{ $abilityConfig['name'] }}" value="allow"
                                            {{ $abilityConfig['state'] == 'allow' ? 'checked' : '' }}>
                                        <span class="ml-2">Allow</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer" @click.stop>
                                        <input @click.stop
                                            wire:model="{{ $abilitiesKey }}.{{ $key }}.abilities.{{ $configKey }}.state"
                                            type="radio" class="form-radio text-pink-500"
                                            name="{{ $abilityConfig['name'] }}" value="deny"
                                            {{ $abilityConfig['state'] == 'deny' ? 'checked' : '' }}>
                                        <span class="ml-2">Deny</span>
                                    </label>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </article>
    </section>
    @endforeach
</div>