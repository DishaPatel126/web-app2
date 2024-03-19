<form action="">
    <div class="ml-[9.9rem] md:ml-48 lg:ml-64">
        <div class="flex flex-col md:flex-row justify-center mt-16 md:mt-20 md:mx-18 md:justify-evenly">
            <div class="w-full w-2/3 md:w-1/3 mx-auto md:mx-0 pb-3">
                <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                    for="from">
                    From URL
                </label>
                <input
                    class="flex h-10 w-full rounded-md border border-black/30 bg-transparent px-3 py-2 text-sm placeholder:text-gray-600 focus:outline-none focus:ring-1 focus:ring-black/30 focus:ring-offset-1 disabled:cursor-not-allowed disabled:opacity-50"
                    type="text" placeholder="Enter your name" id="from" />
                <p class="mt-1 text-xs text-gray-500" id="error"></p>
            </div>

            <div class="w-full w-2/3 md:w-1/3 mx-auto md:mx-0 pb-3">
                <label
                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                    for="to">
                    To URL
                </label>
                <input
                    class="flex h-10 w-full rounded-md border border-black/30 bg-transparent px-3 py-2 text-sm placeholder:text-gray-600 focus:outline-none focus:ring-1 focus:ring-black/30 focus:ring-offset-1 disabled:cursor-not-allowed disabled:opacity-50"
                    type="text" placeholder="Enter your name" id="to" />
                <p class="mt-1 text-xs text-gray-500" id="error"></p>
            </div>
        </div>


        <div class="flex justify-center pt-2">
            <button type="button"
                class="inline-flex items-center rounded-md bg-lightCyan px-6 py-3 text-sm font-bold text-richBlue hover:bg-burntSienna/80">
                Connect
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                    class="ml-2 h-4 w-4">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </button>
        </div>
    </div>
</form>
