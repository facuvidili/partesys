<div

    
    @if($pollMillis !== null && $pollAction !== null)
        wire:poll.{{ $pollMillis }}ms="{{ $pollAction }}"
    @elseif($pollMillis !== null)
        wire:poll.{{ $pollMillis }}ms
    @endif
>
    <div>
        @includeIf($beforeCalendarView)
    </div>
    
    <div class="flex">
        <div class="overflow-x-auto w-full" >
            <div class="inline-block min-w-full overflow-hidden mt-6">


                {{-- AGREGADO POR MI --}}
                <div class="mb-0 float-left">
                    <h2 class="text-2xl">{{ $this->startsAt->formatLocalized('%b %Y') }}</h2>
                </div>
                
                <div>
                    <x-jet-button wire:click="goToNextMonth" class="mr-1 mb-2 float-right">
                        >
                     </x-jet-button>
                    
                </div>
                <div>
                    <x-jet-button wire:click="goToCurrentMonth" class="mr-1 mb-2 float-right">
                        Actual
                     </x-jet-button>
                </div>
                <div>
                    <x-jet-button wire:click="goToPreviousMonth" class="mr-1 mb-2 float-right">
                       <
                    </x-jet-button>
                </div>
                

                <div class="w-full flex flex-row">
                    @foreach($monthGrid->first() as $day)
                        @include($dayOfWeekView, ['day' => $day])
                    @endforeach
                </div>

                @foreach($monthGrid as $week)
                    <div class="w-full flex flex-row">
                        @foreach($week as $day)
                            @include($dayView, [
                                    'componentId' => $componentId,
                                    'day' => $day,
                                    'dayInMonth' => $day->isSameMonth($startsAt),
                                    'isToday' => $day->isToday(),
                                    'events' => $getEventsForDay($day, $events),
                                ])
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
  



   


    <div>
        @includeIf($afterCalendarView)
    </div>
    
   





</div>
