<div
    class="{{ $class ?? 'bg-white' }} w-full h-[152px] rounded-2xl border border-light-purple relative overflow-hidden">
    <div class="p-6 pb-0">
        <p class="text-[#090909] text-sm font-medium">{{ $test ?? 'Card Text' }}</p>
    </div>

    <div class="absolute top-6 right-6">
        <div class="relative w-[18px] h-[18px]">
            <img src="/images/icons/move.svg" alt="">
        </div>
    </div>
    <div class="absolute bottom-6 left-6">
        <div class="bg-white rounded-lg border border-[#EFEFFF] p-2.5 shadow-sm">
            <img src="{{ $icon ?? asset('images/icons/user.svg') }}" alt="">
        </div>
    </div>

    <!-- Numbers in bottom right -->
    <div class="absolute bottom-6 left-20 text-[#090909] text-3xl font-medium">
        {{ $number ?? 0 }}
    </div>

    <!-- Purple glow effect -->
    <div class="absolute -bottom-16 -right-16 w-40 h-40 rounded-full blur-3xl" style="background: {{ $bg ?? '' }};">
    </div>
</div>
