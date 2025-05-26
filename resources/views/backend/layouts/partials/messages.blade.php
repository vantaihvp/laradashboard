@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-1 mb-2" role="alert">
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ __($error) }}</p>
            @endforeach
        </div>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" aria-label="Close" onclick="this.parentElement.remove()">
            <span class="text-red-500">&times;</span>
        </button>
    </div>
@endif

@if (Session::has('success'))
    <div id="success-message" class="relative w-full overflow-hidden" role="alert">
        <div class="flex w-full items-center gap-2 bg-green-500/10 p-4 border border-green-500 rounded-sm">
            <div class="bg-green-500/15 text-green-500 rounded-full p-1" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-2">
                <p class="text-xs font-medium sm:text-sm">
                    {!! __(Session::get('success')) !!}
                </p>
            </div>
            <button class="ml-auto" aria-label="dismiss alert" onclick="this.parentElement.remove()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="2.5" class="size-4 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                const successMessage = document.getElementById('success-message');
                if (successMessage) {
                    successMessage.remove();
                }
            }, 5000);
        });
    </script>
@endif

@if (Session::has('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-1 mb-2" role="alert">
        <span>{{ __(Session::get('error')) }}</span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" aria-label="Close" onclick="this.parentElement.remove()">
            <span class="text-red-500">&times;</span>
        </button>
    </div>
@endif