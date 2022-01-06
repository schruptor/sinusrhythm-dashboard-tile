<x-dashboard-tile :position="$position">
    <div
        class="grid gap-2 justify-items-center h-full"
        style="grid-template-rows: auto 1fr auto;"
    >
        <h1 class="font-medium text-dimmed text-sm uppercase tracking-wide tabular-nums">Heartbeats</h1>

        <div
            wire:poll.60s
            class="uppercase text-dimmed text-sm uppercase tracking-wide tabular-nums"
            style="font-size: {{ config('dashboard.tiles.sinusrhythm.without-prefix') === false ? '0.6' : '0.8' }}rem;"
        >
            @foreach($status as $site => $statuses)
                <p style="text-decoration: underline;">
                    {{ $site }}
                </p>
                @foreach($statuses as $singleStatus)
                    <p style="margin-left: 1rem;">
                        {{ $singleStatus['job'] }} => {{ $singleStatus['status'] }}<br />
                    </p>
                @endforeach
                <br />
            @endforeach
        </div>
    </div>
</x-dashboard-tile>
