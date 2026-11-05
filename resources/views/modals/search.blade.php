<div id="search-modal" class="z-10 hidden lg:hidden bg-green-500/0 p-10">
   
    <form action="{{ url('/search') }}" class="max-w-md mx-auto">  
        @csrf
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="search" name="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-gray-500 focus:border-gray-500" placeholder="Search movie..." required />
            <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-gray-900 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring--300 font-medium rounded-lg text-sm px-4 py-2">Search</button>
        </div>
    </form>

</div>